<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRoleRequest;

use Acme\Facades\Activity;
use App\UserRole;
use App\UserRolePermission;
use App\UserPermission;
use App\Seo;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if ($name = $request->name) {
            $data = UserRole::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        } else {
            $data = UserRole::paginate(25);
        }
        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/user_roles/index')
            ->with('title', 'User Roles')
            ->with('menu', 'user_roles')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function create()
    {   
        $permissions = UserPermission::has('children')->orWhere('parent',0)->get();
        $parentIds = [];
        foreach ($permissions as $p) {
            # code...
            $parentIds[] = $p->parent;
        }
        foreach ($permissions as $p) {
            # code...
            $ids[] = $p->id;
        }
        return view('admin/user_roles/create')
            ->with('title', 'Create User Role')
            ->with('permissions', $permissions)
            ->with('parentIds',$parentIds)
            ->with('ids',$ids)
            ->with('menu', 'user_roles');
    }
    public function createUserRolePermission($input,$user_role_id){
        foreach ($input['ids'] as $id) {
            $user_permission = UserRolePermission::where('user_role_id',$user_role_id)
                                                ->where('user_permission_id',$id)
                                                ->first();
            if(!$user_permission){
                $user_permission = new UserRolePermission;
                $user_permission->user_role_id = $user_role_id;
                $user_permission->user_permission_id = $id;
                $user_permission->save();
            }
        }
    }
    public function store(UserRoleRequest $request)
    {
        $input = $request->all();
        $user_role = UserRole::create($input);
        if(isset($input['ids'])){
            $this->createUserRolePermission($input,$user_role->id);
        }
        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to edit.',
            'resetForm'=>true,
            'redirect'=>route('adminUserRolesEdit', [$user_role->id])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/user_roles/show')
            ->with('title', 'Show User Role')
            ->with('data', UserRole::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/user_roles/view')
            ->with('title', 'View User Role')
            ->with('menu', 'user_roles')
            ->with('data', UserRole::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = UserRole::with('permissions')->findOrFail($id);
        
        $permissions = UserPermission::has('children')->orWhere('parent',0)->get();
        $parentIds = [];
        foreach ($permissions as $p) {
            # code...
            $parentIds[] = $p->parent;
        }
        foreach ($permissions as $p) {
            # code...
            $ids[] = $p->id;
        }
        $permissionIds = [];
        foreach($data->permissions as $p){
            $permissionIds[] = $p->user_permission_id;
        }

        return view('admin/user_roles/edit')
            ->with('title', 'Edit User Role')
            ->with('menu', 'user_roles')
            ->with('data', $data)
            ->with('permissions', $permissions)
            ->with('permissionIds', $permissionIds)
            ->with('parentIds',$parentIds)
            ->with('ids',$ids);
    }

    public function update(UserRoleRequest $request, $id)
    {
        $input = $request->all();
        $user_role = UserRole::findOrFail($id);
        $user_role->update($input);

        if(isset($input['ids'])){
            $this->createUserRolePermission($input,$user_role->id);
        }

        $permissions = UserRolePermission::where('user_role_id',$id)->get();
        foreach ($permissions as $p) {
            # code...
            if(!in_array($p->user_permission_id,$input['ids'])){
                $p->delete();
            }
        }

        $response = [
            'notifTitle'=>'Save successful.',
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = UserRole::findOrFail($input['seoable_id']);
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

        $data = UserRole::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        // $log = 'deletes a new user_role "' . implode(', ', $names) . '"';
        // Activity::create($log);

        UserRole::destroy($input['ids']);

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminUserRoles')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/user_roles', array('as'=>'adminUserRoles','uses'=>'Admin\UserRoleController@index'));
Route::get('admin/user_roles/create', array('as'=>'adminUserRolesCreate','uses'=>'Admin\UserRoleController@create'));
Route::post('admin/user_roles/', array('as'=>'adminUserRolesStore','uses'=>'Admin\UserRoleController@store'));
Route::get('admin/user_roles/{id}/show', array('as'=>'adminUserRolesShow','uses'=>'Admin\UserRoleController@show'));
Route::get('admin/user_roles/{id}/view', array('as'=>'adminUserRolesView','uses'=>'Admin\UserRoleController@view'));
Route::get('admin/user_roles/{id}/edit', array('as'=>'adminUserRolesEdit','uses'=>'Admin\UserRoleController@edit'));
Route::patch('admin/user_roles/{id}', array('as'=>'adminUserRolesUpdate','uses'=>'Admin\UserRoleController@update'));
Route::post('admin/user_roles/seo', array('as'=>'adminUserRolesSeo','uses'=>'Admin\UserRoleController@seo'));
Route::delete('admin/user_roles/destroy', array('as'=>'adminUserRolesDestroy','uses'=>'Admin\UserRoleController@destroy'));
*/
}
