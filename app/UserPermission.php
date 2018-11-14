<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPermission extends BaseModel
{
    
    use SoftDeletes;

    protected $fillable = [
    	'name',
        'slug',
        'description',
        'parent',
        'master',
        'order',
    	];
    
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }

    public function children() {
        return $this->hasMany(static::class, 'parent');
    }

    public function getSlugAttribute($value){
        return $this->attributes['slug'] = md5($value);
    }
}
