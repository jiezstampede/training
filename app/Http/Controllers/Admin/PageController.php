<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

use Acme\Facades\Activity;
use Acme\Facades\General;
use App\Page;
use App\PageCategory;
use App\Seo;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = Page::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $data = Page::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/pages/index')
            ->with('title', 'Pages')
            ->with('menu', 'pages')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
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
    
    public function edit($id)
    {
        $data = Page::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/pages/edit')
            ->with('title', 'Edit page')
            ->with('menu', 'pages')
            ->with('data', $data)
            ->with('seo', $seo)
            ->with('categories', PageCategory::lists('name','id'));
    }

    public function update(PageRequest $request, $id)
    {
        $input = $request->all();
        $page = Page::findOrFail($id);
        $page->update($input);

        // $log = 'edits a page "' . $page->name . '"';
        // Activity::create($log);

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
        $data->seo()->save($seo);

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
            $names[] = $d->name;
        }
        // $log = 'deletes a new page "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Page::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminPages')
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
