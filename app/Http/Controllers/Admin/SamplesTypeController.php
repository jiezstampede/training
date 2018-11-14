<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SamplesTypeRequest;

use Acme\Facades\Activity;

use App\SamplesType;
use App\Seo;

class SamplesTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($sample_id = $request->sample_id) {
            $data = SamplesType::where('sample_id', 'LIKE', '%' . $sample_id . '%')->paginate(25);
        } else {
            $data = SamplesType::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/samples_types/index')
            ->with('title', 'SamplesTypes')
            ->with('menu', 'samples_types')
            ->with('keyword', $request->sample_id)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/samples_types/create')
            ->with('title', 'Create samples_type')
            ->with('menu', 'samples_types');
    }
    
    public function store(SamplesTypeRequest $request)
    {
        $input = $request->all();
        $samples_type = SamplesType::create($input);
        
        // $log = 'creates a new samples_type "' . $samples_type->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminSamplesTypesEdit', [$samples_type->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/samples_types/show')
            ->with('title', 'Show samples_type')
            ->with('data', SamplesType::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/samples_types/view')
            ->with('title', 'View samples_type')
            ->with('menu', 'samples_types')
            ->with('data', SamplesType::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = SamplesType::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/samples_types/edit')
            ->with('title', 'Edit samples_type')
            ->with('menu', 'samples_types')
            ->with('data', $data)
            ->with('seo', $seo);
    }
    
    public function update(SamplesTypeRequest $request, $id)
    {
        $input = $request->all();
        $samples_type = SamplesType::findOrFail($id);
        $samples_type->update($input);

        // $log = 'edits a samples_type "' . $samples_type->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = SamplesType::findOrFail($input['seoable_id']);
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

        $data = SamplesType::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->sample_id;
        }
        // $log = 'deletes a new samples_type "' . implode(', ', $names) . '"';
        // Activity::create($log);

        SamplesType::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminSamplesTypes')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/samples_types', array('as'=>'adminSamplesTypes','uses'=>'Admin\SamplesTypeController@index'));
Route::get('admin/samples_types/create', array('as'=>'adminSamplesTypesCreate','uses'=>'Admin\SamplesTypeController@create'));
Route::post('admin/samples_types/', array('as'=>'adminSamplesTypesStore','uses'=>'Admin\SamplesTypeController@store'));
Route::get('admin/samples_types/{id}/show', array('as'=>'adminSamplesTypesShow','uses'=>'Admin\SamplesTypeController@show'));
Route::get('admin/samples_types/{id}/view', array('as'=>'adminSamplesTypesView','uses'=>'Admin\SamplesTypeController@view'));
Route::get('admin/samples_types/{id}/edit', array('as'=>'adminSamplesTypesEdit','uses'=>'Admin\SamplesTypeController@edit'));
Route::patch('admin/samples_types/{id}', array('as'=>'adminSamplesTypesUpdate','uses'=>'Admin\SamplesTypeController@update'));
Route::post('admin/samples_types/seo', array('as'=>'adminSamplesTypesSeo','uses'=>'Admin\SamplesTypeController@seo'));
Route::delete('admin/samples_types/destroy', array('as'=>'adminSamplesTypesDestroy','uses'=>'Admin\SamplesTypeController@destroy'));
*/
}
