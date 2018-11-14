<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPermissionRequest;

use Acme\Facades\Activity;
use Acme\Facades\General;
use App\UserPermission;
use App\Seo;

class UserPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request,$id)
    {

        // if ($name = $request->name) {
        //     $data = UserPermission::where('name', 'LIKE', '%' . $name . '%')->paginate(25);
        // } else {
        //     $data = UserPermission::paginate(25);
        // }

        // $pagination = $data->appends($request->except('page'))->links();
        $permissions = UserPermission::orderBy('order', 'ASC')
                                ->where('parent', $id)
                                ->get();
        $parent = 0;
        $parentTitle = 'Root';
        if ($id > 0) {   
            $parent = UserPermission::findOrFail($id);
            $parentTitle = $parent->name;
        }

        $permissionParents = array();
        $p_id = $id;
        while ($p_id > 0) {
            $p = UserPermission::findOrFail($p_id);
            $p_id = $p->parent;
            $permissionParents[] = $p;
        }
        $permissionParents = array_reverse($permissionParents);

        return view('admin/user_permissions/index')
            ->with('title', 'Functions under '.$parentTitle)
            ->with('menu', 'user_permissions')
            ->with('keyword', $request->title)
            ->with('parent_id', $id)
            ->with('parent_title', $parentTitle)
            ->with('permission_parents', $permissionParents)
            ->with('permissions', $permissions);





        $pagination = $data->appends($request->except('page'))->links();

        return view('admin/user_permissions/index')
            ->with('title', 'Functions')
            ->with('menu', 'user_permissions')
            ->with('keyword', $request->name)
            ->with('data', $data)
            ->with('pagination', $pagination);
    }

    public function order(Request $request)
    {
        $counter = 1;
        foreach ($request['order'] as $o) {
            $update['order'] = $counter;
            $permission = UserPermission::findOrFail($o);
            $permission->update($update);
            $counter++;
        }
        return response()->json($request);
    }

    public function create($parent)
    {
        $id = $parent;
        $parent = 0;
        $parent_title = 'Parent';
        if ($id > 0) {   
            $parent = UserPermission::findOrFail($id);
            $parent_title = $parent->name;
        }

        $permissionParents = array();
        $p_id = $id;
        while ($p_id > 0) {
            $p = UserPermission::findOrFail($p_id);
            $p_id = $p->parent;
            $permissionParents[] = $p;
        }
        $permissionParents = array_reverse($permissionParents);

        return view('admin/user_permissions/create')
            ->with('title', 'Create Sub Functions in '.$parent_title)
            ->with('menu', 'products')
            ->with('parent_id', $id)
            ->with('parent_title', $parent_title)
            ->with('permission_parents', $permissionParents);

        // return view('admin/user_permissions/create')
        //     ->with('title', 'Create user_permission')
        //     ->with('menu', 'user_permissions');
    }

    public function createPermission($parent)
    {  
        $id = $parent;
        $parent = 0;
        $parent_title = 'Parent';
        if ($id > 0) {   
            $parent = UserPermission::findOrFail($id);
            $parent_title = $parent->name;
        }

        $permissionParents = array();
        $p_id = $id;
        while ($p_id > 0) {
            $p = UserPermission::findOrFail($p_id);
            $p_id = $p->parent;
            $permissionParents[] = $p;
        }
        $permissionParents = array_reverse($permissionParents);

        return view('admin/user_permissions/create')
            ->with('title', 'Create Sub Functions in '.$parent_title)
            ->with('menu', 'products')
            ->with('parent_id', $id)
            ->with('parent_title', $parent_title)
            ->with('permission_parents', $permissionParents);
    }

    
    public function store(UserPermissionRequest $request)
    {
        $input = $request->all();

        $curCat = UserPermission::where('parent', $input['parent'])->get();
        $input['order'] =  count($curCat) + 1;

        $function = UserPermission::create($input);

        $input['slug'] = General::slug($function->name,$function->id);

        if ($input['parent'] == 0) {
            $input['master'] = $function->id;
        } else {
            $input['master'] = UserPermission::findOrFail($request['parent'])->master;
        }
        $function->update($input);  

        $parent = 0;
        $parentTitle = 'Root';
        if ($input['parent'] > 0) {   
            $parent = UserPermission::findOrFail($input['parent']);
            $parentTitle = $parent->name;
        }
        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to ' . $parentTitle . ' Functions.',
            'resetForm'=>true,
            'redirect'=>route('adminUserPermissions', [$input['parent']])
        ];

        return response()->json($response);
    }
    
    public function show($id)
    {
        return view('admin/user_permissions/show')
            ->with('title', 'Show Function')
            ->with('data', UserPermission::findOrFail($id));
    }

    public function view($id)
    {
        return view('admin/user_permissions/view')
            ->with('title', 'View Function')
            ->with('menu', 'user_permissions')
            ->with('data', UserPermission::findOrFail($id));
    }
    
    public function edit($id)
    {
        $data = UserPermission::findOrFail($id);
        $parent_title = 'Parent';
        if ($id > 0) {   
            $parent = UserPermission::findOrFail($id);
            $parent_title = $parent->name;
        }

        $permissionParents = array();
        $p_id = $id;
        while ($p_id > 0) {
            $p = UserPermission::findOrFail($p_id);
            $p_id = $p->parent;
            $permissionParents[] = $p;
        }
        $permissionParents = array_reverse($permissionParents);

        return view('admin/user_permissions/edit')
            ->with('title', 'Edit Functions')
            ->with('menu', 'user_permissions')
            ->with('data', $data)
            ->with('parent_id', $id)
            ->with('parent_title', $parent_title)
            ->with('permission_parents', $permissionParents);
    }

    public function update(UserPermissionRequest $request, $id)
    {
        $input = $request->all();
        unset($input['parent']); //unset parent, cant be change for edit.
        $user_permission = UserPermission::findOrFail($id);
        $user_permission->update($input);

        $parentTitle = 'Root';
        if ($user_permission->parent > 0) {   
            $parent = UserPermission::findOrFail($user_permission->parent);
            $parentTitle = $parent->name;
        }
        if(!$parent){
            $parent->id = 0;
        }
        $response = [
            'notifTitle'=>'Save successful.',
            'notifMessage'=>'Redirecting to ' . $parentTitle . ' Functions.',
            'resetForm'=>true,
            'redirect'=>route('adminUserPermissions', [$parent->id])
        ];

        return response()->json($response);
    }

    public function seo(Request $request)
    {
        $input = $request->all();

        $data = UserPermission::findOrFail($input['seoable_id']);
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

        $data = UserPermission::whereIn('id', $input['ids'])->get();
        $names = [];
        foreach ($data as $d) {
            $names[] = $d->name;
        }
        UserPermission::destroy($input['ids']);
        $permission_id = 0;
        $permissionTitle = 'Parent';
        if ($input['permission'] > 0) {
            $permission = UserPermission::findOrFail($input['permission']);
            $permissionTitle = $permission->title;
        }

        $newData = UserPermission::where('parent', $input['permission'])->orderBy('order', 'ASC')->get();
        $counter = 1;
        foreach ($newData as $n) {
            $update['order'] = $counter;
            $permission = UserPermission::findOrFail($n->id);
            $permission->update($update);
            $counter++;
        }

        $response = [
            'notifTitle'=>'Delete successful.',
            'notifMessage'=>'Refreshing page.',
            'redirect'=>route('adminUserPermissions')
        ];

        return response()->json($response);
    }
    
/** Copy/paste these lines to app\Http\routes.base.php 
Route::get('admin/user_permissions', array('as'=>'adminUserPermissions','uses'=>'Admin\UserPermissionController@index'));
Route::get('admin/user_permissions/create', array('as'=>'adminUserPermissionsCreate','uses'=>'Admin\UserPermissionController@create'));
Route::post('admin/user_permissions/', array('as'=>'adminUserPermissionsStore','uses'=>'Admin\UserPermissionController@store'));
Route::get('admin/user_permissions/{id}/show', array('as'=>'adminUserPermissionsShow','uses'=>'Admin\UserPermissionController@show'));
Route::get('admin/user_permissions/{id}/view', array('as'=>'adminUserPermissionsView','uses'=>'Admin\UserPermissionController@view'));
Route::get('admin/user_permissions/{id}/edit', array('as'=>'adminUserPermissionsEdit','uses'=>'Admin\UserPermissionController@edit'));
Route::patch('admin/user_permissions/{id}', array('as'=>'adminUserPermissionsUpdate','uses'=>'Admin\UserPermissionController@update'));
Route::post('admin/user_permissions/seo', array('as'=>'adminUserPermissionsSeo','uses'=>'Admin\UserPermissionController@seo'));
Route::delete('admin/user_permissions/destroy', array('as'=>'adminUserPermissionsDestroy','uses'=>'Admin\UserPermissionController@destroy'));
*/
}
