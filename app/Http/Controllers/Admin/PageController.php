<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

use Acme\Facades\Activity;
use Acme\Facades\General;
use App\Page;
use App\PageItem;
use App\PageCategory;
use App\Seo;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request, $slug)
    {
        $data = Page::where('slug', $slug)->first();

        return view('admin/pages/' . $slug . '/index')
            ->with('title', 'Pages')
            ->with('menu', 'pages-' . $slug)
            ->with('slug', $slug)
            ->with('seo', @$data->seo()->first())
            ->with('data', @$data);
    }

    public function create()
    {
        return view('admin/pages/create')
            ->with('title', 'Create page')
            ->with('menu', 'pages')
            ->with('categories', PageCategory::lists('name','id'));
    }
    
    public function store(PageRequest $request)
    {
        $input = $request->all();
        $page = Page::create($input);

        $input['slug'] = General::slug($page->name,$page->id);
        $page->update($input);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminPagesEdit', [$page->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/pages/show')
            ->with('title', 'Show page')
            ->with('data', Page::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/pages/view')
            ->with('title', 'View page')
            ->with('menu', 'pages')
            ->with('data', Page::findOrFail($id));
    }
    
    public function edit($slug, $section)
    {
		$page = Page::where('slug', $slug)->first();
		$data = Page::where('slug', $section)->first();
		$menu = 'pages-';
		$view = '';
		foreach(explode("-", $section) as $key => $dir) {
			if ($key == 0) $menu .= $dir;
			$view .= ('/' . $dir); 
		}
		return view('admin/pages/' . $view . '/edit')
            ->with('title', 'Edit page')
            ->with('menu', $menu)
            ->with('page', $page)
            ->with('data', $data);
    }

    public function update(PageRequest $request, $id)
    {
        $input = $request->all();
        $page = Page::findOrFail($id);
        $page->update($input);

        $log = 'edited the page "' . $page->slug . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
		$input = $request->all();

        $data = Page::findOrFail($input['seoable_id']);
        $seo = Seo::whereSeoable_id($input['seoable_id'])->whereSeoable_type($input['seoable_type'])->first();
        if (is_null($seo)) {
            $seo = new Seo;
        }
        $seo->title = $input['title'];
        $seo->description = $input['description'];
        $seo->image = $input['image'];
        $seo->seoable_id = $input['seoable_id'];
        $seo->seoable_type = $input['seoable_type'];
        $seo->save();

        $log = 'edited the seo of page "' . $data->slug . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'SEO Save successful.',
        ];

        return response()->json($response);
    }
    
    public function destroy(Request $request)
    {
        $input = $request->all();

        $data = Page::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->slug;
        }
        $log = 'deleted a page "' . implode(', ', $names) . '"';
        Activity::create($log);

        Page::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminPages')
        ];

        return response()->json($response);
	}
	
	public function storeItem(Request $request, $slug)
	{
		$input = $request->all();
		$input['slug'] = $slug;
		$data = PageItem::create($input);
		$response['data'] = $data;
		$response['message'] = 'Save successful';
        $status = 200;
        
        $log = 'created a new "' . $data->slug . '" item';
        Activity::create($log);
		
		return response($response, $status);
	}
	public function storeItemFromPage(PageRequest $request, $section, $slug)
    {
		$sectionSlugs = [];
		$c_slug = "";
		foreach(explode("-", $section) as $key => $dir) {
			if ($key > 0) $c_slug .= '-';
			$c_slug .= $dir; 
			array_push($sectionSlugs, $c_slug);
		}
		
		$input = $request->all();
		if (@$input['icon_type'] == 'font-awesome') {
			$input['value'] = $input['icon_font_awesome'];
			$input['image'] = null;
		}
		if (@$input['icon_type'] == 'image') {
			$input['image'] = $input['icon_image'];
			$input['value'] = $input['icon_type'];
		}
		$input['slug'] = $slug;
        $page = PageItem::create($input);
        
        $log = 'created a new "' . $page->slug . '" item';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'resetForm'=>true,
            'redirect'=>route('adminPagesEdit', [$sectionSlugs[count($sectionSlugs)-2], $sectionSlugs[count($sectionSlugs)-1]])
        ];

        return response()->json($response);
    }
	public function deleteItem(Request $request)
	{
		$input = $request->all();
		PageItem::destroy($input['id']);
		$response['message'] = 'Delete successful';
        $status = 200;
        
        $log = 'deleted a "' . $page->slug . '" item';
        Activity::create($log);
		
		return response($response, $status);
	}
	public function updateItem(Request $request)
	{
		$input = $request->all();
		$data = PageItem::findOrFail($input['id']);
        $data->update($input);

        $log = 'edited a "' . $page->slug . '" item';
        Activity::create($log);
        
		$response['data'] = $data;
		$response['message'] = 'Save successful';
		$status = 200;
		
		return response($response, $status);
	}
	public function updateItemFromPage(PageRequest $request, $id)
    {
		$input = $request->all();
		if (@$input['icon_type'] == 'font-awesome') {
			$input['value'] = $input['icon_font_awesome'];
			$input['image'] = null;
		}
		if (@$input['icon_type'] == 'image') {
			$input['image'] = $input['icon_image'];
			$input['value'] = $input['icon_type'];
		}
        $page = PageItem::findOrFail($id);
        $page->update($input);

        $log = 'edited a "' . $page->slug . '" item';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }
	public function editItem(Request $request, $slug, $id)
	{
		$data = PageItem::findOrFail($id);
		$menu = 'pages-';
		$view = '';
		foreach(explode("-", $slug) as $key => $dir) {
			if ($key == 0) $menu .= $dir;
			$view .= ('/' . $dir); 
		}
		return view('admin/pages/' . $view . '/items/edit')
            ->with('title', 'Edit page')
            ->with('menu', $menu)
            ->with('slug', $slug)
            ->with('data', $data);
	}
	public function createItem(Request $request, $slug)
	{
		$menu = 'pages-';
		$view = '';
		foreach(explode("-", $slug) as $key => $dir) {
			if ($key == 0) $menu .= $dir;
			$view .= ('/' . $dir); 
		}
		return view('admin/pages/' . $view . '/items/create')
            ->with('title', 'Edit page')
            ->with('menu', $menu)
            ->with('slug', $slug);
    }
    
    public function sortItem(Request $request, $slug)
    {
        $input = $request->all();
        $counter = 1;
        foreach (@$input['general'] as $o) {
            $update['order'] = $counter;
            $permission = Page::findOrFail($o);
            $permission->update($update);
            $counter++;
        }
        
        $log = 'reordered the items from "' . $slug . '"';
        Activity::create($log);

		$response = [
			'notifTitle'=>'Reordered successful.',
        ];
        return response()->json($response);
    }
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/pages', array('as'=>'adminPages','uses'=>'Admin\PageController@index'));
Route::get('admin/pages/create', array('as'=>'adminPagesCreate','uses'=>'Admin\PageController@create'));
Route::post('admin/pages/', array('as'=>'adminPagesStore','uses'=>'Admin\PageController@store'));
Route::get('admin/pages/{id}/show', array('as'=>'adminPagesShow','uses'=>'Admin\PageController@show'));
Route::get('admin/pages/{id}/view', array('as'=>'adminPagesView','uses'=>'Admin\PageController@view'));
Route::get('admin/pages/{id}/edit', array('as'=>'adminPagesEdit','uses'=>'Admin\PageController@edit'));
Route::patch('admin/pages/{id}', array('as'=>'adminPagesUpdate','uses'=>'Admin\PageController@update'));
Route::post('admin/pages/seo', array('as'=>'adminPagesSeo','uses'=>'Admin\PageController@seo'));
Route::delete('admin/pages/destroy', array('as'=>'adminPagesDestroy','uses'=>'Admin\PageController@destroy'));
*/
}
