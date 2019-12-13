<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;

use Acme\Facades\Activity;
use App\OrderItem;
use App\Transaction;
use App\Seo;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($number = $request->number) {
            $data = Transaction::where('number', 'LIKE', '%' . $number . '%')->orderBy('date', 'desc')->paginate(25);
        } else {
            $data = Transaction::orderBy('date', 'desc')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/transactions/index')
            ->with('title', 'Transactions')
            ->with('menu', 'transactions')
            ->with('keyword', $request->number)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/transactions/create')
            ->with('title', 'Create transaction')
            ->with('menu', 'transactions');
    }
    public function upload()
    {
        return view('admin/transactions/upload')
            ->with('title', 'Upload Transactions from CSV')
            ->with('menu', 'transactions');
    }

    public function upload_submit(Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file = fopen($file->getPathname(), 'r');
            $transactions = [];
            $key = 0;
            while (($column = fgetcsv($file)) !== FALSE) {
                if ($key != 0) {
                    $exists = Orderitem::where('number', $column[14])->first();
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
                        'exists' => ($exists != null && $exists != ''),
                    ];
                    $transactions[] = $tmpTransaction;
                }
                $key++;
            }
            return view('admin/transactions/upload')
                ->with('transactions', $transactions)
                ->with('title', 'Transactions | Review uploaded CSV')
                ->with('menu', 'transactions');
        } else {
            return redirect('adminTransactions');
        }
    }

    public function upload_csv_submit(Request $request)
    {
        $input = $request->all();
        try {
            $transactions = json_decode($input['transactions']);

            foreach ($transactions as $tr) {
                $orderItem = OrderItem::where('number', $tr->order_item)->first();
                if ($orderItem) {
                    $newTransaction = Transaction::where('number', $tr->number)->first();
                    if (!$newTransaction) $newTransaction = new Transaction();

                    $newTransaction->number = $tr->number;
                    $newTransaction->date = Carbon::parse($tr->date);
                    $newTransaction->type = $tr->type;
                    $newTransaction->fee_name = $tr->fee_name;
                    $newTransaction->amount = $tr->amount;
                    $newTransaction->vat = $tr->vat;
                    $newTransaction->wht = $tr->wht;
                    $newTransaction->paid_status = $tr->paid_status;
                    $newTransaction->order_number = $tr->order_number;
                    $newTransaction->order_item_number = $tr->order_item;
                    $newTransaction->save();
                }
            }

            $response = [
                'notifTitle' => 'Save successful.',
                'notifMessage' => 'Redirecting to transactions list.',
                'redirect' => route('adminTransactions')
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

    public function store(TransactionRequest $request)
    {
        $input = $request->all();
        $transaction = Transaction::create($input);

        // $log = 'creates a new transaction "' . $transaction->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle' => 'Save successful.',
            'notifMessage' => 'Redirecting to edit.',
            'resetForm' => true,
            'redirect' => route('adminTransactionsEdit', [$transaction->id])
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        return view('admin/transactions/show')
            ->with('title', 'Show transaction')
            ->with('data', Transaction::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/transactions/view')
            ->with('title', 'View transaction')
            ->with('menu', 'transactions')
            ->with('data', Transaction::findOrFail($id));
    }

    public function edit($id)
    {
        $data = Transaction::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/transactions/edit')
            ->with('title', 'Edit transaction')
            ->with('menu', 'transactions')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(TransactionRequest $request, $id)
    {
        $input = $request->all();
        $transaction = Transaction::findOrFail($id);
        $transaction->update($input);

        // $log = 'edits a transaction "' . $transaction->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle' => 'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Transaction::findOrFail($input['seoable_id']);
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

        $data = Transaction::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->number;
        }
        // $log = 'deletes a new transaction "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Transaction::destroy($input['ids']);

        $response = [
            'notifTitle' => 'Delete successful.',
            'notifMessage' => 'Refreshing page.',
            'redirect' => route('adminTransactions')
        ];

        return response()->json($response);
    }

    /** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/transactions', array('as'=>'adminTransactions','uses'=>'Admin\TransactionController@index'));
Route::get('admin/transactions/create', array('as'=>'adminTransactionsCreate','uses'=>'Admin\TransactionController@create'));
Route::post('admin/transactions/', array('as'=>'adminTransactionsStore','uses'=>'Admin\TransactionController@store'));
Route::get('admin/transactions/{id}/show', array('as'=>'adminTransactionsShow','uses'=>'Admin\TransactionController@show'));
Route::get('admin/transactions/{id}/view', array('as'=>'adminTransactionsView','uses'=>'Admin\TransactionController@view'));
Route::get('admin/transactions/{id}/edit', array('as'=>'adminTransactionsEdit','uses'=>'Admin\TransactionController@edit'));
Route::patch('admin/transactions/{id}', array('as'=>'adminTransactionsUpdate','uses'=>'Admin\TransactionController@update'));
Route::post('admin/transactions/seo', array('as'=>'adminTransactionsSeo','uses'=>'Admin\TransactionController@seo'));
Route::delete('admin/transactions/destroy', array('as'=>'adminTransactionsDestroy','uses'=>'Admin\TransactionController@destroy'));
     */
}
