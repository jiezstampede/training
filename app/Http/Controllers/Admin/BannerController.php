<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;

use Acme\Facades\Activity;
use App\Banner;
use App\Seo;

use Image;
use App\Asset;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = Banner::where('name', 'LIKE', '%' . $name . '%')->orderBy('order', 'ASC');
        } else {
            $data = Banner::orderBy('order', 'ASC')->paginate(2);
        }

        return view('admin/banners/index')
            ->with('title', 'Banners')
            ->with('menu', 'banners')
            ->with('keyword', $request->name)
            ->with('data', $data);
    }

    public function create()
    {
        return view('admin/banners/create')
            ->with('title', 'Create banner')
            ->with('menu', 'banners');
    }

    public function store(BannerRequest $request)
    {
        $input = $request->all();
        $banner = Banner::create($input);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminBannersEdit', [$banner->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/banners/show')
            ->with('title', 'Show banner')
            ->with('data', Banner::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/banners/view')
            ->with('title', 'View banner')
            ->with('menu', 'banners')
            ->with('data', Banner::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = Banner::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/banners/edit')
            ->with('title', 'Edit banner')
            ->with('menu', 'banners')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function order(Request $request)
    {  
   
        $input=[];
        $data = $request->input('banner');
        $newOrder=1;
        foreach($data as $d)
        {
            $input['order'] = $newOrder;
            $banner = Banner::findOrFail($d);
            $banner->update($input);
            $newOrder++;
        }

         $response = [
            'notifTitle'=>'Banner order updated.',
        ];
        return response()->json($response);
    }

    public function update(BannerRequest $request, $id)
    {
        $input = $request->all();
        $banner = Banner::findOrFail($id);
        $banner->update($input);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Banner::findOrFail($input['seoable_id']);
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

        $data = Banner::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new banner "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Banner::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminBanners')
        ];

        return response()->json($response);
    }
    
    public function crop_url(Request $request)
    {
        $input = $request->all();
        $response = [
            'redirect'=>route('adminBannersCropForm', [$input['id'], $input['column'], $input['asset_id']])
        ];

        return response()->json($response);
    }

    public function crop_form($id, $column, $asset_id)
    {
        $dimensions = ['width'=>300, 'height'=>300];

        return view('admin/banners/crop')
            ->with('title', 'Crop Image')
            ->with('data', Banner::findOrFail($id))
            ->with('column', $column)
            ->with('asset', Asset::findOrFail($asset_id))
            ->with('dimensions', $dimensions);
    }

    public function crop(Request $request, $id)
    {
        $input = $request->all();
        $asset = Asset::findOrFail($input['asset_id']);
        
        $filename = str_slug('banner-' . $id . '-' . $input['column']);
        $image = Image::make($asset->path);
        $thumbnail = 'upload/thumbnails/' . $filename . '.' . $image->extension;
        $image->crop($input['crop_width'], $input['crop_height'], $input['x'], $input['y'])
            ->resize($input['target_width'], $input['target_height'])
            ->save($thumbnail, 100);

        $data = Banner::findOrFail($id);
        $data->$input['column'] = $thumbnail;
        $data->save();

        $log = 'crops ' . $input['column'] . ' of banner "' . $data->name . '"';
        Activity::create($log);

        $response = [
            'notifTitle'=>'Crop successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminBannersCropForm', [$data->id, $input['column'], $asset->id])
        ];

        return response()->json($response);
    }

/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/banners', array('as'=>'adminBanners','uses'=>'Admin\BannerController@index'));
Route::get('admin/banners/create', array('as'=>'adminBannersCreate','uses'=>'Admin\BannerController@create'));
Route::post('admin/banners/', array('as'=>'adminBannersStore','uses'=>'Admin\BannerController@store'));
Route::get('admin/banners/{id}/show', array('as'=>'adminBannersShow','uses'=>'Admin\BannerController@show'));
Route::get('admin/banners/{id}/view', array('as'=>'adminBannersView','uses'=>'Admin\BannerController@view'));
Route::get('admin/banners/{id}/edit', array('as'=>'adminBannersEdit','uses'=>'Admin\BannerController@edit'));
Route::patch('admin/banners/{id}', array('as'=>'adminBannersUpdate','uses'=>'Admin\BannerController@update'));
Route::post('admin/banners/seo', array('as'=>'adminBannersSeo','uses'=>'Admin\BannerController@seo'));
Route::delete('admin/banners/destroy', array('as'=>'adminBannersDestroy','uses'=>'Admin\BannerController@destroy'));
Route::get('admin/banners/crop/url', array('as'=>'adminBannersCropUrl','uses'=>'Admin\BannerController@crop_url'));
Route::get('admin/banners/{id}/crop/{column}/{asset_id}', array('as'=>'adminBannersCropForm','uses'=>'Admin\BannerController@crop_form'));
Route::patch('admin/banners/{id}/crop', array('as'=>'adminBannersCrop','uses'=>'Admin\BannerController@crop'));
*/
}
