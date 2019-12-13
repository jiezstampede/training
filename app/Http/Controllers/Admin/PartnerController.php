<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;

use Acme\Facades\Activity;
use Acme\Facades\General;
use App\Partner;
use App\Seo;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = Partner::where('name', 'LIKE', '%' . $name . '%')->orderBy('order', 'ASC')->paginate(25);
        } else {
            $data = Partner::orderBy('order', 'ASC')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/partners/index')
            ->with('title', 'Partners')
            ->with('menu', 'partners')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/partners/create')
            ->with('title', 'Create partner')
            ->with('menu', 'partners');
    }
    
    public function store(PartnerRequest $request)
    {
        $input = $request->all();
        $partner = Partner::create($input);
        
		$input['slug'] = General::slug($partner->name,$partner->id);
		$partner->update($input);

        // $log = 'creates a new partner "' . $partner->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminPartnersEdit', [$partner->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/partners/show')
            ->with('title', 'Show partner')
            ->with('data', Partner::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/partners/view')
            ->with('title', 'View partner')
            ->with('menu', 'partners')
            ->with('data', Partner::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = Partner::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/partners/edit')
            ->with('title', 'Edit partner')
            ->with('menu', 'partners')
            ->with('data', $data)
            ->with('seo', $seo);
    }
        
    //API function for ordering items
    public function order(Request $request)
    {
        $input=[];
        $data = $request->input('partners');
        $newOrder=1;
        foreach($data as $d)
        {
            $input['order'] = $newOrder;
            $partner = Partner::findOrFail($d);
            $partner->update($input);
            $newOrder++;
        }

         $response = [
            'notifTitle'=>'Partner order updated.',
        ];
        return response()->json($response);
    }

    public function update(PartnerRequest $request, $id)
    {
        $input = $request->all();
        $partner = Partner::findOrFail($id);
        $partner->update($input);

        // $log = 'edits a partner "' . $partner->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = Partner::findOrFail($input['seoable_id']);
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

        $data = Partner::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new partner "' . implode(', ', $names) . '"';
        // Activity::create($log);

        Partner::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminPartners')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/partners', array('as'=>'adminPartners','uses'=>'Admin\PartnerController@index'));
Route::get('admin/partners/create', array('as'=>'adminPartnersCreate','uses'=>'Admin\PartnerController@create'));
Route::post('admin/partners/', array('as'=>'adminPartnersStore','uses'=>'Admin\PartnerController@store'));
Route::get('admin/partners/{id}/show', array('as'=>'adminPartnersShow','uses'=>'Admin\PartnerController@show'));
Route::get('admin/partners/{id}/view', array('as'=>'adminPartnersView','uses'=>'Admin\PartnerController@view'));
Route::get('admin/partners/{id}/edit', array('as'=>'adminPartnersEdit','uses'=>'Admin\PartnerController@edit'));
Route::patch('admin/partners/{id}', array('as'=>'adminPartnersUpdate','uses'=>'Admin\PartnerController@update'));
Route::post('admin/partners/seo', array('as'=>'adminPartnersSeo','uses'=>'Admin\PartnerController@seo'));
Route::delete('admin/partners/destroy', array('as'=>'adminPartnersDestroy','uses'=>'Admin\PartnerController@destroy'));
Route::get('admin/partners/order', array('as'=>'adminPartnersOrder','uses'=>'Admin\PartnerController@order'));
*/
}
