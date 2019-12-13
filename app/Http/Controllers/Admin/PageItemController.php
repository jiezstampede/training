<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageItemRequest;

use Acme\Facades\Activity;
use Acme\Facades\General;
use App\PageItem;
use App\Seo;

class PageItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($page_id = $request->page_id) {
            $data = PageItem::where('page_id', 'LIKE', '%' . $page_id . '%')->orderBy('order', 'ASC')->paginate(25);
        } else {
            $data = PageItem::orderBy('order', 'ASC')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/page_items/index')
            ->with('title', 'PageItems')
            ->with('menu', 'page_items')
            ->with('keyword', $request->page_id)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/page_items/create')
            ->with('title', 'Create page_item')
            ->with('menu', 'page_items');
    }
    
    public function store(PageItemRequest $request)
    {
        $input = $request->all();
        $page_item = PageItem::create($input);
        
		$input['slug'] = General::slug($page_item->page_id,$page_item->id);
		$page_item->update($input);

        // $log = 'creates a new page_item "' . $page_item->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminPageItemsEdit', [$page_item->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/page_items/show')
            ->with('title', 'Show page_item')
            ->with('data', PageItem::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/page_items/view')
            ->with('title', 'View page_item')
            ->with('menu', 'page_items')
            ->with('data', PageItem::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = PageItem::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/page_items/edit')
            ->with('title', 'Edit page_item')
            ->with('menu', 'page_items')
            ->with('data', $data)
            ->with('seo', $seo);
    }
        
    //API function for ordering items
    public function order(Request $request)
    {
        $input=[];
        $data = $request->input('page_items');
        $newOrder=1;
        foreach($data as $d)
        {
            $input['order'] = $newOrder;
            $page_item = PageItem::findOrFail($d);
            $page_item->update($input);
            $newOrder++;
        }

         $response = [
            'notifTitle'=>'PageItem order updated.',
        ];
        return response()->json($response);
    }

    public function update(PageItemRequest $request, $id)
    {
        $input = $request->all();
        $page_item = PageItem::findOrFail($id);
        $page_item->update($input);

        // $log = 'edits a page_item "' . $page_item->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = PageItem::findOrFail($input['seoable_id']);
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

        $data = PageItem::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->page_id;
        }
        // $log = 'deletes a new page_item "' . implode(', ', $names) . '"';
        // Activity::create($log);

        PageItem::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminPageItems')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/page_items', array('as'=>'adminPageItems','uses'=>'Admin\PageItemController@index'));
Route::get('admin/page_items/create', array('as'=>'adminPageItemsCreate','uses'=>'Admin\PageItemController@create'));
Route::post('admin/page_items/', array('as'=>'adminPageItemsStore','uses'=>'Admin\PageItemController@store'));
Route::get('admin/page_items/{id}/show', array('as'=>'adminPageItemsShow','uses'=>'Admin\PageItemController@show'));
Route::get('admin/page_items/{id}/view', array('as'=>'adminPageItemsView','uses'=>'Admin\PageItemController@view'));
Route::get('admin/page_items/{id}/edit', array('as'=>'adminPageItemsEdit','uses'=>'Admin\PageItemController@edit'));
Route::patch('admin/page_items/{id}', array('as'=>'adminPageItemsUpdate','uses'=>'Admin\PageItemController@update'));
Route::post('admin/page_items/seo', array('as'=>'adminPageItemsSeo','uses'=>'Admin\PageItemController@seo'));
Route::delete('admin/page_items/destroy', array('as'=>'adminPageItemsDestroy','uses'=>'Admin\PageItemController@destroy'));
Route::get('admin/page_items/order', array('as'=>'adminPageItemsOrder','uses'=>'Admin\PageItemController@order'));
*/
}
