<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends BaseModel
{
    
    use SoftDeletes;

    protected $fillable = [
    	'name',
        'description',
    	];
    
    
    
    public function permissions()
    {
        return $this->hasMany('App\UserRolePermission');
    }
}
