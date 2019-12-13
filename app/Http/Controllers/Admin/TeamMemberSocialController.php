<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamMemberSocialRequest;

use Acme\Facades\Activity;

use App\TeamMemberSocial;
use App\Seo;

class TeamMemberSocialController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($team_member_id = $request->team_member_id) {
            $data = TeamMemberSocial::where('team_member_id', 'LIKE', '%' . $team_member_id . '%')->orderBy('order', 'ASC')->paginate(25);
        } else {
            $data = TeamMemberSocial::orderBy('order', 'ASC')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/team_member_socials/index')
            ->with('title', 'TeamMemberSocials')
            ->with('menu', 'team_member_socials')
            ->with('keyword', $request->team_member_id)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/team_member_socials/create')
            ->with('title', 'Create team_member_social')
            ->with('menu', 'team_member_socials');
    }
    
    public function store(TeamMemberSocialRequest $request)
    {
        $input = $request->all();
        $team_member_social = TeamMemberSocial::create($input);
        
        // $log = 'creates a new team_member_social "' . $team_member_social->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminTeamMemberSocialsEdit', [$team_member_social->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/team_member_socials/show')
            ->with('title', 'Show team_member_social')
            ->with('data', TeamMemberSocial::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/team_member_socials/view')
            ->with('title', 'View team_member_social')
            ->with('menu', 'team_member_socials')
            ->with('data', TeamMemberSocial::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = TeamMemberSocial::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/team_member_socials/edit')
            ->with('title', 'Edit team_member_social')
            ->with('menu', 'team_member_socials')
            ->with('data', $data)
            ->with('seo', $seo);
    }
        
    //API function for ordering items
    public function order(Request $request)
    {
        $input=[];
        $data = $request->input('team_member_socials');
        $newOrder=1;
        foreach($data as $d)
        {
            $input['order'] = $newOrder;
            $team_member_social = TeamMemberSocial::findOrFail($d);
            $team_member_social->update($input);
            $newOrder++;
        }

         $response = [
            'notifTitle'=>'TeamMemberSocial order updated.',
        ];
        return response()->json($response);
    }

    public function update(TeamMemberSocialRequest $request, $id)
    {
        $input = $request->all();
        $team_member_social = TeamMemberSocial::findOrFail($id);
        $team_member_social->update($input);

        // $log = 'edits a team_member_social "' . $team_member_social->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = TeamMemberSocial::findOrFail($input['seoable_id']);
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

        $data = TeamMemberSocial::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->team_member_id;
        }
        // $log = 'deletes a new team_member_social "' . implode(', ', $names) . '"';
        // Activity::create($log);

        TeamMemberSocial::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminTeamMemberSocials')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/team_member_socials', array('as'=>'adminTeamMemberSocials','uses'=>'Admin\TeamMemberSocialController@index'));
Route::get('admin/team_member_socials/create', array('as'=>'adminTeamMemberSocialsCreate','uses'=>'Admin\TeamMemberSocialController@create'));
Route::post('admin/team_member_socials/', array('as'=>'adminTeamMemberSocialsStore','uses'=>'Admin\TeamMemberSocialController@store'));
Route::get('admin/team_member_socials/{id}/show', array('as'=>'adminTeamMemberSocialsShow','uses'=>'Admin\TeamMemberSocialController@show'));
Route::get('admin/team_member_socials/{id}/view', array('as'=>'adminTeamMemberSocialsView','uses'=>'Admin\TeamMemberSocialController@view'));
Route::get('admin/team_member_socials/{id}/edit', array('as'=>'adminTeamMemberSocialsEdit','uses'=>'Admin\TeamMemberSocialController@edit'));
Route::patch('admin/team_member_socials/{id}', array('as'=>'adminTeamMemberSocialsUpdate','uses'=>'Admin\TeamMemberSocialController@update'));
Route::post('admin/team_member_socials/seo', array('as'=>'adminTeamMemberSocialsSeo','uses'=>'Admin\TeamMemberSocialController@seo'));
Route::delete('admin/team_member_socials/destroy', array('as'=>'adminTeamMemberSocialsDestroy','uses'=>'Admin\TeamMemberSocialController@destroy'));
Route::get('admin/team_member_socials/order', array('as'=>'adminTeamMemberSocialsOrder','uses'=>'Admin\TeamMemberSocialController@order'));
*/
}
