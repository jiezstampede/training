<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRolePermissionRequest;

use Acme\Facades\Activity;
use App\UserRolePermission;
use App\Seo;

class UserRolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($user_role_id = $request->user_role_id) {
            $data = UserRolePermission::where('user_role_id', 'LIKE', '%' . $user_role_id . '%')->paginate(25);
        } else {
            $data = UserRolePermission::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/user_role_permissions/index')
            ->with('title', 'UserRolePermissions')
            ->with('menu', 'user_role_permissions')
            ->with('keyword', $request->user_role_id)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {
        return view('admin/user_role_permissions/create')
            ->with('title', 'Create user_role_permission')
            ->with('menu', 'user_role_permissions');
    }
    
    public function store(UserRolePermissionRequest $request)
    {
        $input = $request->all();
        $user_role_permission = UserRolePermission::create($input);

        // $log = 'creates a new user_role_permission "' . $user_role_permission->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminUserRolePermissionsEdit', [$user_role_permission->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/user_role_permissions/show')
            ->with('title', 'Show user_role_permission')
            ->with('data', UserRolePermission::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/user_role_permissions/view')
            ->with('title', 'View user_role_permission')
            ->with('menu', 'user_role_permissions')
            ->with('data', UserRolePermission::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = UserRolePermission::findOrFail($id);
        $seo = $data->seo()->first();

        return view('admin/user_role_permissions/edit')
            ->with('title', 'Edit user_role_permission')
            ->with('menu', 'user_role_permissions')
            ->with('data', $data)
            ->with('seo', $seo);
    }

    public function update(UserRolePermissionRequest $request, $id)
    {
        $input = $request->all();
        $user_role_permission = UserRolePermission::findOrFail($id);
        $user_role_permission->update($input);

        // $log = 'edits a user_role_permission "' . $user_role_permission->name . '"';
        // Activity::create($log);

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = UserRolePermission::findOrFail($input['seoable_id']);
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

        $data = UserRolePermission::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->user_role_id;
        }
        // $log = 'deletes a new user_role_permission "' . implode(', ', $names) . '"';
        // Activity::create($log);

        UserRolePermission::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminUserRolePermissions')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/user_role_permissions', array('as'=>'adminUserRolePermissions','uses'=>'Admin\UserRolePermissionController@index'));
Route::get('admin/user_role_permissions/create', array('as'=>'adminUserRolePermissionsCreate','uses'=>'Admin\UserRolePermissionController@create'));
Route::post('admin/user_role_permissions/', array('as'=>'adminUserRolePermissionsStore','uses'=>'Admin\UserRolePermissionController@store'));
Route::get('admin/user_role_permissions/{id}/show', array('as'=>'adminUserRolePermissionsShow','uses'=>'Admin\UserRolePermissionController@show'));
Route::get('admin/user_role_permissions/{id}/view', array('as'=>'adminUserRolePermissionsView','uses'=>'Admin\UserRolePermissionController@view'));
Route::get('admin/user_role_permissions/{id}/edit', array('as'=>'adminUserRolePermissionsEdit','uses'=>'Admin\UserRolePermissionController@edit'));
Route::patch('admin/user_role_permissions/{id}', array('as'=>'adminUserRolePermissionsUpdate','uses'=>'Admin\UserRolePermissionController@update'));
Route::post('admin/user_role_permissions/seo', array('as'=>'adminUserRolePermissionsSeo','uses'=>'Admin\UserRolePermissionController@seo'));
Route::delete('admin/user_role_permissions/destroy', array('as'=>'adminUserRolePermissionsDestroy','uses'=>'Admin\UserRolePermissionController@destroy'));
*/
}
