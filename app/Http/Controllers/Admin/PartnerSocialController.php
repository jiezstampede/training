<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerSocialRequest;

use Acme\Facades\Activity;

use App\PartnerSocial;
use App\Seo;

class PartnerSocialController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($partner_id = $request->partner_id) {
            $data = PartnerSocial::where('partner_id', 'LIKE', '%' . $partner_id . '%')->orderBy('order', 'ASC')->paginate(25);
        } else {
            $data = PartnerSocial::orderBy('order', 'ASC')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/partner_socials/index')
            ->with('title', 'PartnerSocials')
            ->with('menu', 'partner_socials')
            ->with('keyword', $request->partner_id)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/partner_socials/create')
            ->with('title', 'Create partner_social')
            ->with('menu', 'partner_socials');
    }
    
    public function store(PartnerSocialRequest $request)
    {
        $input = $request->all();
        $partner_social = PartnerSocial::create($input);
        
        // $log = 'creates a new partner_social "' . $partner_social->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminPartnerSocialsEdit', [$partner_social->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/partner_socials/show')
            ->with('title', 'Show partner_social')
            ->with('data', PartnerSocial::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/partner_socials/view')
            ->with('title', 'View partner_social')
            ->with('menu', 'partner_socials')
            ->with('data', PartnerSocial::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = PartnerSocial::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/partner_socials/edit')
            ->with('title', 'Edit partner_social')
            ->with('menu', 'partner_socials')
            ->with('data', $data)
            ->with('seo', $seo);
    }
        
    //API function for ordering items
    public function order(Request $request)
    {
        $input=[];
        $data = $request->input('partner_socials');
        $newOrder=1;
        foreach($data as $d)
        {
            $input['order'] = $newOrder;
            $partner_social = PartnerSocial::findOrFail($d);
            $partner_social->update($input);
            $newOrder++;
        }

         $response = [
            'notifTitle'=>'PartnerSocial order updated.',
        ];
        return response()->json($response);
    }

    public function update(PartnerSocialRequest $request, $id)
    {
        $input = $request->all();
        $partner_social = PartnerSocial::findOrFail($id);
        $partner_social->update($input);

        // $log = 'edits a partner_social "' . $partner_social->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = PartnerSocial::findOrFail($input['seoable_id']);
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

        $data = PartnerSocial::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->partner_id;
        }
        // $log = 'deletes a new partner_social "' . implode(', ', $names) . '"';
        // Activity::create($log);

        PartnerSocial::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminPartnerSocials')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/partner_socials', array('as'=>'adminPartnerSocials','uses'=>'Admin\PartnerSocialController@index'));
Route::get('admin/partner_socials/create', array('as'=>'adminPartnerSocialsCreate','uses'=>'Admin\PartnerSocialController@create'));
Route::post('admin/partner_socials/', array('as'=>'adminPartnerSocialsStore','uses'=>'Admin\PartnerSocialController@store'));
Route::get('admin/partner_socials/{id}/show', array('as'=>'adminPartnerSocialsShow','uses'=>'Admin\PartnerSocialController@show'));
Route::get('admin/partner_socials/{id}/view', array('as'=>'adminPartnerSocialsView','uses'=>'Admin\PartnerSocialController@view'));
Route::get('admin/partner_socials/{id}/edit', array('as'=>'adminPartnerSocialsEdit','uses'=>'Admin\PartnerSocialController@edit'));
Route::patch('admin/partner_socials/{id}', array('as'=>'adminPartnerSocialsUpdate','uses'=>'Admin\PartnerSocialController@update'));
Route::post('admin/partner_socials/seo', array('as'=>'adminPartnerSocialsSeo','uses'=>'Admin\PartnerSocialController@seo'));
Route::delete('admin/partner_socials/destroy', array('as'=>'adminPartnerSocialsDestroy','uses'=>'Admin\PartnerSocialController@destroy'));
Route::get('admin/partner_socials/order', array('as'=>'adminPartnerSocialsOrder','uses'=>'Admin\PartnerSocialController@order'));
*/
}
