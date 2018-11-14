<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token','user_role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function permissions(){
        return $this->hasMany('App\UserRolePermission','user_role_id','user_role_id')
            ->select(array('user_role_permissions.*','user_permissions.slug','user_permissions.id as user_permission_id'))
            ->join('user_permissions', 'user_permissions.id', '=', 'user_role_permissions.user_permission_id');
    }

}
