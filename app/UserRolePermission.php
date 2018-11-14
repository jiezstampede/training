<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class UserRolePermission extends BaseModel
{
    

    protected $fillable = [
    	'user_role_id',
        'user_permission_id',
    	];
    

    public function permissions(){
        return $this->hasOne('App\UserPermission','id','user_permission_id')
                ->select(array('id','slug'));
    }
}
