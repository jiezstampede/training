<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class AssetGroup extends BaseModel
{
    
    protected $fillable = [
    	'name',
        'reference_id',
        'reference_type',
    	];
    
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }

    public function assets()
    {
        return $this->hasMany('App\AssetGroupItem', 'group_id');
    }
}
