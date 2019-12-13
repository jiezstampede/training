<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItemRequest;

use Acme\Facades\Activity;

use App\OrderItem;
use App\Seo;

class OrderItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($number = $request->number) {
            $data = OrderItem::where('number', 'LIKE', '%' . $number . '%')->paginate(25);
        } else {
            $data = OrderItem::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/order_items/index')
            ->with('title', 'OrderItems')
            ->with('menu', 'order_items')
            ->with('keyword', $request->number)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/order_items/create')
            ->with('title', 'Create order_item')
            ->with('menu', 'order_items');
    }
    
    public function store(OrderItemRequest $request)
    {
        $input = $request->all();
        $order_item = OrderItem::create($input);
        
        // $log = 'creates a new order_item "' . $order_item->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminOrderItemsEdit', [$order_item->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/order_items/show')
            ->with('title', 'Show order_item')
            ->with('data', OrderItem::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/order_items/view')
            ->with('title', 'View order_item')
            ->with('menu', 'order_items')
            ->with('data', OrderItem::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = OrderItem::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/order_items/edit')
            ->with('title', 'Edit order_item')
            ->with('menu', 'order_items')
            ->with('data', $data)
            ->with('seo', $seo);
    }
    
    public function update(OrderItemRequest $request, $id)
    {
        $input = $request->all();
        $order_item = OrderItem::findOrFail($id);
        $order_item->update($input);

        // $log = 'edits a order_item "' . $order_item->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = OrderItem::findOrFail($input['seoable_id']);
        $seo = Seo::whereSeoable_id($input['seoable_id'])->whereSeoable_type($input['seoable_type'])->first();
        if (is_null($seo)) {
            $seo = new Seo;
        }
        $seo->title = $input['title'];
        $seo->description = $input['description'];
        $seo->image = $input['image'];
        $data->seo()->save($seo);

        $response = [
            'notifTitle'=>'SEO Save successful.',
        ];

        return response()->json($response);
    }
    
    public function destroy(Request $request)
    {
        $input = $request->all();

        $data = OrderItem::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->number;
        }
        // $log = 'deletes a new order_item "' . implode(', ', $names) . '"';
        // Activity::create($log);

        OrderItem::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminOrderItems')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/order_items', array('as'=>'adminOrderItems','uses'=>'Admin\OrderItemController@index'));
Route::get('admin/order_items/create', array('as'=>'adminOrderItemsCreate','uses'=>'Admin\OrderItemController@create'));
Route::post('admin/order_items/', array('as'=>'adminOrderItemsStore','uses'=>'Admin\OrderItemController@store'));
Route::get('admin/order_items/{id}/show', array('as'=>'adminOrderItemsShow','uses'=>'Admin\OrderItemController@show'));
Route::get('admin/order_items/{id}/view', array('as'=>'adminOrderItemsView','uses'=>'Admin\OrderItemController@view'));
Route::get('admin/order_items/{id}/edit', array('as'=>'adminOrderItemsEdit','uses'=>'Admin\OrderItemController@edit'));
Route::patch('admin/order_items/{id}', array('as'=>'adminOrderItemsUpdate','uses'=>'Admin\OrderItemController@update'));
Route::post('admin/order_items/seo', array('as'=>'adminOrderItemsSeo','uses'=>'Admin\OrderItemController@seo'));
Route::delete('admin/order_items/destroy', array('as'=>'adminOrderItemsDestroy','uses'=>'Admin\OrderItemController@destroy'));
*/
}
