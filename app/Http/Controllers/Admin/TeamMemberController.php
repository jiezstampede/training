<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamMemberRequest;

use Acme\Facades\Activity;
use Acme\Facades\General;
use App\TeamMember;
use App\Seo;

class TeamMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = TeamMember::where('name', 'LIKE', '%' . $name . '%')->orderBy('order', 'ASC')->paginate(25);
        } else {
            $data = TeamMember::orderBy('order', 'ASC')->paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/team_members/index')
            ->with('title', 'TeamMembers')
            ->with('menu', 'team_members')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/team_members/create')
            ->with('title', 'Create team_member')
            ->with('menu', 'team_members');
    }
    
    public function store(TeamMemberRequest $request)
    {
        $input = $request->all();
        $team_member = TeamMember::create($input);
        
		$input['slug'] = General::slug($team_member->name,$team_member->id);
		$team_member->update($input);

        // $log = 'creates a new team_member "' . $team_member->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminTeamMembersEdit', [$team_member->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/team_members/show')
            ->with('title', 'Show team_member')
            ->with('data', TeamMember::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/team_members/view')
            ->with('title', 'View team_member')
            ->with('menu', 'team_members')
            ->with('data', TeamMember::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = TeamMember::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/team_members/edit')
            ->with('title', 'Edit team_member')
            ->with('menu', 'team_members')
            ->with('data', $data)
            ->with('seo', $seo);
    }
        
    //API function for ordering items
    public function order(Request $request)
    {
        $input=[];
        $data = $request->input('team_members');
        $newOrder=1;
        foreach($data as $d)
        {
            $input['order'] = $newOrder;
            $team_member = TeamMember::findOrFail($d);
            $team_member->update($input);
            $newOrder++;
        }

         $response = [
            'notifTitle'=>'TeamMember order updated.',
        ];
        return response()->json($response);
    }

    public function update(TeamMemberRequest $request, $id)
    {
        $input = $request->all();
        $team_member = TeamMember::findOrFail($id);
        $team_member->update($input);

        // $log = 'edits a team_member "' . $team_member->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = TeamMember::findOrFail($input['seoable_id']);
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

        $data = TeamMember::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new team_member "' . implode(', ', $names) . '"';
        // Activity::create($log);

        TeamMember::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminTeamMembers')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/team_members', array('as'=>'adminTeamMembers','uses'=>'Admin\TeamMemberController@index'));
Route::get('admin/team_members/create', array('as'=>'adminTeamMembersCreate','uses'=>'Admin\TeamMemberController@create'));
Route::post('admin/team_members/', array('as'=>'adminTeamMembersStore','uses'=>'Admin\TeamMemberController@store'));
Route::get('admin/team_members/{id}/show', array('as'=>'adminTeamMembersShow','uses'=>'Admin\TeamMemberController@show'));
Route::get('admin/team_members/{id}/view', array('as'=>'adminTeamMembersView','uses'=>'Admin\TeamMemberController@view'));
Route::get('admin/team_members/{id}/edit', array('as'=>'adminTeamMembersEdit','uses'=>'Admin\TeamMemberController@edit'));
Route::patch('admin/team_members/{id}', array('as'=>'adminTeamMembersUpdate','uses'=>'Admin\TeamMemberController@update'));
Route::post('admin/team_members/seo', array('as'=>'adminTeamMembersSeo','uses'=>'Admin\TeamMemberController@seo'));
Route::delete('admin/team_members/destroy', array('as'=>'adminTeamMembersDestroy','uses'=>'Admin\TeamMemberController@destroy'));
Route::get('admin/team_members/order', array('as'=>'adminTeamMembersOrder','uses'=>'Admin\TeamMemberController@order'));
*/
}
