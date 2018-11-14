<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageCategoryRequest;

use Acme\Facades\Activity;
use Acme\Facades\General;
use App\PageCategory;
use App\Seo;

class PageCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = PageCategory::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $data = PageCategory::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/page_categories/index')
            ->with('title', 'Page Categories')
            ->with('menu', 'page_categories')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/page_categories/create')
            ->with('title', 'Create Page Category')
            ->with('menu', 'page_categories');
    }
    
    public function store(PageCategoryRequest $request)
    {
        $input = $request->all();
        $page_category = PageCategory::create($input);

        $input['slug'] = General::slug($page_category->name,$page_category->id);
        $page_category->update($input);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminPageCategoriesEdit', [$page_category->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/page_categories/show')
            ->with('title', 'Show Page Category')
            ->with('data', PageCategory::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/page_categories/view')
            ->with('title', 'View Page Category')
            ->with('menu', 'page_categories')
            ->with('data', PageCategory::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = PageCategory::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/page_categories/edit')
            ->with('title', 'Edit Page Category')
            ->with('menu', 'page_categories')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(PageCategoryRequest $request, $id)
    {
        $input = $request->all();
        $page_category = PageCategory::findOrFail($id);
        $page_category->update($input);

        // $log = 'edits a page_category "' . $page_category->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = PageCategory::findOrFail($input['seoable_id']);
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

        $data = PageCategory::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new page_category "' . implode(', ', $names) . '"';
        // Activity::create($log);

        PageCategory::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminPageCategories')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/page_categories', array('as'=>'adminPageCategories','uses'=>'Admin\PageCategoryController@index'));
Route::get('admin/page_categories/create', array('as'=>'adminPageCategoriesCreate','uses'=>'Admin\PageCategoryController@create'));
Route::post('admin/page_categories/', array('as'=>'adminPageCategoriesStore','uses'=>'Admin\PageCategoryController@store'));
Route::get('admin/page_categories/{id}/show', array('as'=>'adminPageCategoriesShow','uses'=>'Admin\PageCategoryController@show'));
Route::get('admin/page_categories/{id}/view', array('as'=>'adminPageCategoriesView','uses'=>'Admin\PageCategoryController@view'));
Route::get('admin/page_categories/{id}/edit', array('as'=>'adminPageCategoriesEdit','uses'=>'Admin\PageCategoryController@edit'));
Route::patch('admin/page_categories/{id}', array('as'=>'adminPageCategoriesUpdate','uses'=>'Admin\PageCategoryController@update'));
Route::post('admin/page_categories/seo', array('as'=>'adminPageCategoriesSeo','uses'=>'Admin\PageCategoryController@seo'));
Route::delete('admin/page_categories/destroy', array('as'=>'adminPageCategoriesDestroy','uses'=>'Admin\PageCategoryController@destroy'));
*/
}
