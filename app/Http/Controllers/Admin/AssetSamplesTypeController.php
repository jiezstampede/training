<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetSamplesTypeRequest;

use Acme\Facades\Activity;

use App\AssetSamplesType;
use App\Seo;

class AssetSamplesTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($asset_id = $request->asset_id) {
            $data = AssetSamplesType::where('asset_id', 'LIKE', '%' . $asset_id . '%')->orderBy('order', 'ASC')->paginate(25);
        } else {
            $data = AssetSamplesType::orderBy('order', 'ASC')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/asset_samples_type/index')
            ->with('title', 'AssetSamplesType')
            ->with('menu', 'asset_samples_type')
            ->with('keyword', $request->asset_id)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/asset_samples_type/create')
            ->with('title', 'Create asset_samples_type')
            ->with('menu', 'asset_samples_type');
    }
    
    public function store(AssetSamplesTypeRequest $request)
    {
        $input = $request->all();
        $asset_samples_type = AssetSamplesType::create($input);
        
        // $log = 'creates a new asset_samples_type "' . $asset_samples_type->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminAssetSamplesTypeEdit', [$asset_samples_type->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/asset_samples_type/show')
            ->with('title', 'Show asset_samples_type')
            ->with('data', AssetSamplesType::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/asset_samples_type/view')
            ->with('title', 'View asset_samples_type')
            ->with('menu', 'asset_samples_type')
            ->with('data', AssetSamplesType::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = AssetSamplesType::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/asset_samples_type/edit')
            ->with('title', 'Edit asset_samples_type')
            ->with('menu', 'asset_samples_type')
            ->with('data', $data)
            ->with('seo', $seo);
    }
        
    //API function for ordering items
    public function order(Request $request)
    {
        $input=[];
        $data = $request->input('asset_samples_type');
        $newOrder=1;
        foreach($data as $d)
        {
            $input['order'] = $newOrder;
            $asset_samples_type = AssetSamplesType::findOrFail($d);
            $asset_samples_type->update($input);
            $newOrder++;
        }

         $response = [
            'notifTitle'=>'AssetSamplesType order updated.',
        ];
        return response()->json($response);
    }

    public function update(AssetSamplesTypeRequest $request, $id)
    {
        $input = $request->all();
        $asset_samples_type = AssetSamplesType::findOrFail($id);
        $asset_samples_type->update($input);

        // $log = 'edits a asset_samples_type "' . $asset_samples_type->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = AssetSamplesType::findOrFail($input['seoable_id']);
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

        $data = AssetSamplesType::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->asset_id;
        }
        // $log = 'deletes a new asset_samples_type "' . implode(', ', $names) . '"';
        // Activity::create($log);

        AssetSamplesType::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminAssetSamplesType')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/asset_samples_type', array('as'=>'adminAssetSamplesType','uses'=>'Admin\AssetSamplesTypeController@index'));
Route::get('admin/asset_samples_type/create', array('as'=>'adminAssetSamplesTypeCreate','uses'=>'Admin\AssetSamplesTypeController@create'));
Route::post('admin/asset_samples_type/', array('as'=>'adminAssetSamplesTypeStore','uses'=>'Admin\AssetSamplesTypeController@store'));
Route::get('admin/asset_samples_type/{id}/show', array('as'=>'adminAssetSamplesTypeShow','uses'=>'Admin\AssetSamplesTypeController@show'));
Route::get('admin/asset_samples_type/{id}/view', array('as'=>'adminAssetSamplesTypeView','uses'=>'Admin\AssetSamplesTypeController@view'));
Route::get('admin/asset_samples_type/{id}/edit', array('as'=>'adminAssetSamplesTypeEdit','uses'=>'Admin\AssetSamplesTypeController@edit'));
Route::patch('admin/asset_samples_type/{id}', array('as'=>'adminAssetSamplesTypeUpdate','uses'=>'Admin\AssetSamplesTypeController@update'));
Route::post('admin/asset_samples_type/seo', array('as'=>'adminAssetSamplesTypeSeo','uses'=>'Admin\AssetSamplesTypeController@seo'));
Route::delete('admin/asset_samples_type/destroy', array('as'=>'adminAssetSamplesTypeDestroy','uses'=>'Admin\AssetSamplesTypeController@destroy'));
Route::get('admin/asset_samples_type/order', array('as'=>'adminAssetSamplesTypeOrder','uses'=>'Admin\AssetSamplesTypeController@order'));
*/
}
