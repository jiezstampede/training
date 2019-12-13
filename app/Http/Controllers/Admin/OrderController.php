<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;

use Acme\Facades\Activity;

use App\Order;
use App\OrderItem;
use App\Seo;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($number = $request->number) {
            $data = Order::where('number', 'LIKE', '%' . $number . '%')->orderBy('date', 'desc')->paginate(25);
        } else {
            $data = Order::orderBy('date', 'desc')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/orders/index')
            ->with('title', 'Orders')
            ->with('menu', 'orders')
            ->with('keyword', $request->number)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function upload_csv(Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file = fopen($file->getPathname(), 'r');
            $orders = [];
            $key = 0;
            while (($column = fgetcsv($file)) !== FALSE) {
                if ($key != 0) {
                    $dataString = '';
                    foreach ($column as $str) {
                        $dataString = $dataString . $str;
                    }
                    $data = explode(';', $dataString);
                    $tmpOrderItem = [];
                    $tmpOrderItem['number'] = $data[0];
                    $tmpOrderItem['seller_sku'] = $data[4];
                    $tmpOrderItem['lazada_sku'] = $data[5];
                    $tmpOrderItem['order_date'] = $data[6];
                    $tmpOrderItem['details'] = $data[41];
                    $tmpOrderItem['unit_price'] = $data[38];
                    $tmpOrderItem['shipping_paid'] = $data[39];
                    $tmpOrderItem['shipping_provider'] = $data[44];
                    $tmpOrderItem['delivery_status'] = $data[55];

                    $order_number = $data[8];
                    $orders[$order_number][] = $tmpOrderItem;
                }
                $key++;
            }
            return view('admin/orders/upload_review')
                ->with('orders', $orders)
                ->with('title', 'Orders | Review uploaded CSV')
                ->with('menu', 'orders');
        } else {
            return redirect('adminOrders');
        }
    }

    public function save_uploaded(Request $request)
    {
        $input = $request->all();
        try {
            $orders = json_decode($input['orders']);
            foreach ($orders as $key => $order) {
                $newOrder = Order::where('number', $key)->first();
                if (!$newOrder) $newOrder = new Order;
                $newOrder->number = $key;
                $newOrder->date = $order[0]->order_date;
                $newOrder->save();
                foreach ($order as $item) {
                    $newItem = OrderItem::where('number', $key)->first();
                    if (!$newItem) $newItem = new OrderItem;
                    $newItem->order_id = $newOrder->id;
                    $newItem->order_number = $newOrder->number;
                    $newItem->number = $item->number;
                    $newItem->seller_sku = $item->seller_sku;
                    $newItem->lazada_sku = $item->lazada_sku;
                    $newItem->details = $item->details;
                    $newItem->unit_price = $item->unit_price;
                    $newItem->shipping_paid = $item->shipping_paid;
                    $newItem->shipping_provider = $item->shipping_provider;
                    $newItem->delivery_status = $item->delivery_status;
                    $newItem->save();
                }
            }
            $response = [
                'notifTitle' => 'Save successful.',
                'notifMessage' => 'Redirecting to orders list.',
                'redirect' => route('adminOrders')
            ];
            return response()->json($response);
        } catch (\Exception $e) {
            $response = [
                'notifTitle' => 'Something went wrong.',
                'notifMessage' => 'Please check your review and check your csv file for compatibility.',
            ];
            return response()->json($response);
        }
    }

    public function create()
    {
        return view('admin/orders/create')
            ->with('title', 'Create order')
            ->with('menu', 'orders');
    }

    public function store(OrderRequest $request)
    {
        $input = $request->all();
        $order = Order::create($input);

        // $log = 'creates a new order "' . $order->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle' => 'Save successful.',
            'notifMessage' => 'Redirecting to edit.',
            'resetForm' => true,
            'redirect' => route('adminOrdersEdit', [$order->id])
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        return view('admin/orders/show')
            ->with('title', 'Show order')
            ->with('data', Order::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/orders/view')
            ->with('title', 'View order')
            ->with('menu', 'orders')
            ->with('data', Order::findOrFail($id));
    }

    public function edit($id)
    {
        $data = Order::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/orders/edit')
            ->with('title', 'Edit order')
            ->with('menu', 'orders')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(OrderRequest $request, $id)
    {
        $input = $request->all();
        $order = Order::findOrFail($id);
        $order->update($input);

        // $log = 'edits a order "' . $order->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle' => 'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Order::findOrFail($input['seoable_id']);
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

        $data = Order::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->number;
        }
        // $log = 'deletes a new order "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Order::destroy($input['ids']);

        $response = [
            'notifTitle' => 'Delete successful.',
            'notifMessage' => 'Refreshing page.',
            'redirect' => route('adminOrders')
        ];

        return response()->json($response);
    }

    /** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/orders', array('as'=>'adminOrders','uses'=>'Admin\OrderController@index'));
Route::get('admin/orders/create', array('as'=>'adminOrdersCreate','uses'=>'Admin\OrderController@create'));
Route::post('admin/orders/', array('as'=>'adminOrdersStore','uses'=>'Admin\OrderController@store'));
Route::get('admin/orders/{id}/show', array('as'=>'adminOrdersShow','uses'=>'Admin\OrderController@show'));
Route::get('admin/orders/{id}/view', array('as'=>'adminOrdersView','uses'=>'Admin\OrderController@view'));
Route::get('admin/orders/{id}/edit', array('as'=>'adminOrdersEdit','uses'=>'Admin\OrderController@edit'));
Route::patch('admin/orders/{id}', array('as'=>'adminOrdersUpdate','uses'=>'Admin\OrderController@update'));
Route::post('admin/orders/seo', array('as'=>'adminOrdersSeo','uses'=>'Admin\OrderController@seo'));
Route::delete('admin/orders/destroy', array('as'=>'adminOrdersDestroy','uses'=>'Admin\OrderController@destroy'));
     */
}
