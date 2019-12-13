<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;

use Acme\Facades\Activity;

use App\Subscriber;
use App\Seo;
use App\Order;
use App\OrderItem;
use Carbon;
use Excel;

class ShippingDisputeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $disputes = [];

        if (@$input['month'] != '' && $input['year'] != '') {
            $disputesData = $this->getDisputes($input);
            $data = $disputesData['summary'];
            $disputes = $disputesData['disputes'];
        }
        
        return view('admin/shipping_dispute/index')
            ->with('title', 'Shipping Dispute')
            ->with('menu', 'shipping_dispute')
            ->with('input', $input)
            ->with('data', @$data)
            ->with('disputes', $disputes);
    }

    public function getDisputes($input)
    {
        $start = Carbon::parse($input['year'] . '-' . $input['month'])->startOfMonth();
        $end = Carbon::parse($input['year'] . '-' . $input['month'])->endOfMonth();
        $orderItems = OrderItem::select(['order_items.*', 'orders.date'])->with('transactions')->join('orders', 'orders.id', '=', 'order_items.order_id')->where('orders.date', '>=', $start)->where('orders.date', '<=', $end)->get();

        $disputes = [];

        $data = [];
        $data['total_paid'] = 0;
        $data['total_charged'] = 0;
        $data['total_charged_vat'] = 0;

        foreach ($orderItems as $item) {
            if (count($item->transactions) > 0) {
                $shippingPaid = 0;
                $shippingCharged = 0;
                $shippingChargedVat = 0;
                foreach ($item->transactions as $transaction) {
                    if ($transaction->fee_name == "Shipping Fee (Paid By Customer)") $shippingPaid += abs($transaction->amount);
                    if ($transaction->fee_name == "Shipping Fee (Charged by Lazada)") $shippingCharged += abs($transaction->amount);
                    if ($transaction->fee_name == "Shipping Fee (Charged by Lazada)") $shippingChargedVat += abs($transaction->vat);
                }
                if ($shippingPaid <= 0) $shippingPaid = 50;

                if ($shippingCharged > $shippingPaid) {
                    $tmpDispute = [];

                    $tmpDispute['shipping_paid'] = $shippingPaid;
                    $tmpDispute['shipping_charged'] = $shippingCharged;
                    $tmpDispute['item'] = $item;
                    $disputes[] = $tmpDispute;

                    $data['total_paid'] += $shippingPaid;
                    $data['total_charged'] += $shippingCharged;
                    $data['total_charged_vat'] += $shippingChargedVat;
                }
            }
        }

        return [
            'summary' => $data,
            'disputes' => $disputes
        ];
    }

    public function generate(Request $request)
    {
        $input = $request->all();
        if (@$input['month'] != '' && $input['year'] != '') {

            $disputes = $this->getDisputes($input)['disputes'];

            Excel::load('templates/dispute-xform.xlsx', function ($excel) use ($disputes) {
                $excel->sheet('Shipping Fee Disputes', function ($sheet) use ($disputes) {
                    $startRow = 2;
                    foreach ($disputes as $key => $dispute) {
                        $sheet->row($startRow + $key, array(
                            Carbon::parse($dispute['item']->date)->format('m/d/Y'),
                            $dispute['item']->number,
                            $dispute['item']->seller_sku,
                            $dispute['item']->lazada_sku,
                            $dispute['item']->details,
                            $dispute['shipping_charged'],
                            $dispute['shipping_paid'],
                        ));
                    }
                });
            })->export('xlsx');
        }
    }

    public function upload_csv_submit(Request $request)
    {
        $input = $request->all();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file = fopen($file->getPathname(), 'r');
            $items = [];
            $key = 0;
            while (($column = fgetcsv($file)) !== FALSE) {
                if ($key != 0) {
                    $tmpTransaction = [
                        'date' => $column[0],
                        'number' => $column[3],
                        'type' => $column[1],
                        'fee_name' => $column[2],
                        'details' => $column[4],
                        'seller_sku' => $column[5],
                        'laz_sku' => $column[6],
                        'amount' => $column[7],
                        'vat' => $column[8],
                        'wht' => $column[9],
                        'paid_status' => $column[12],
                        'order_number' => $column[13],
                        'order_item' => $column[14],
                        'order_item_status' => $column[15],
                        'shipping_provider' => $column[16],
                    ];
                    // $item[$tmpTransaction['order_item']]['order_date'] = $transactions['order']
                    // $transactions[] = $tmpTransaction;
                }
                $key++;
            }
            dd($items);
        } else {
            return redirect('adminShippingDisputes');
        }
    }

    public function create()
    {
        return view('admin/shipping_dispute/create')
            ->with('title', 'Create subscriber')
            ->with('menu', 'shipping_dispute');
    }

    public function store(SubscriberRequest $request)
    {
        $input = $request->all();
        $subscriber = Subscriber::create($input);

        // $log = 'creates a new subscriber "' . $subscriber->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle' => 'Save successful.',
            'notifMessage' => 'Redirecting to edit.',
            'resetForm' => true,
            'redirect' => route('adminSubscribersEdit', [$subscriber->id])
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        return view('admin/shipping_dispute/show')
            ->with('title', 'Show subscriber')
            ->with('data', Subscriber::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/shipping_dispute/view')
            ->with('title', 'View subscriber')
            ->with('menu', 'shipping_dispute')
            ->with('data', Subscriber::findOrFail($id));
    }

    public function edit($id)
    {
        $data = Subscriber::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/shipping_dispute/edit')
            ->with('title', 'Edit subscriber')
            ->with('menu', 'shipping_dispute')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(SubscriberRequest $request, $id)
    {
        $input = $request->all();
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->update($input);

        // $log = 'edits a subscriber "' . $subscriber->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle' => 'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Subscriber::findOrFail($input['seoable_id']);
        $seo = Seo::whereSeoable_id($input['seoable_id'])->whereSeoable_type($input['seoable_type'])->first();
        if (is_null($seo)) {
            $seo = new Seo;
        }
        $seo->title = $input['title'];
        $seo->description = $input['description'];
        $seo->image = $input['image'];
        $data->seo()->save($seo);

        $response = [
            'notifTitle' => 'SEO Save successful.',
        ];

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $input = $request->all();

        $data = Subscriber::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new subscriber "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Subscriber::destroy($input['ids']);

        $response = [
            'notifTitle' => 'Delete successful.',
            'notifMessage' => 'Refreshing page.',
            'redirect' => route('adminSubscribers')
        ];

        return response()->json($response);
    }

    /** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/shipping_dispute', array('as'=>'adminSubscribers','uses'=>'Admin\ShippingDisputeController@index'));
Route::get('admin/shipping_dispute/create', array('as'=>'adminSubscribersCreate','uses'=>'Admin\ShippingDisputeController@create'));
Route::post('admin/shipping_dispute/', array('as'=>'adminSubscribersStore','uses'=>'Admin\ShippingDisputeController@store'));
Route::get('admin/shipping_dispute/{id}/show', array('as'=>'adminSubscribersShow','uses'=>'Admin\ShippingDisputeController@show'));
Route::get('admin/shipping_dispute/{id}/view', array('as'=>'adminSubscribersView','uses'=>'Admin\ShippingDisputeController@view'));
Route::get('admin/shipping_dispute/{id}/edit', array('as'=>'adminSubscribersEdit','uses'=>'Admin\ShippingDisputeController@edit'));
Route::patch('admin/shipping_dispute/{id}', array('as'=>'adminSubscribersUpdate','uses'=>'Admin\ShippingDisputeController@update'));
Route::post('admin/shipping_dispute/seo', array('as'=>'adminSubscribersSeo','uses'=>'Admin\ShippingDisputeController@seo'));
Route::delete('admin/shipping_dispute/destroy', array('as'=>'adminSubscribersDestroy','uses'=>'Admin\ShippingDisputeController@destroy'));
     */
}
