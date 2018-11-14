<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class SamplesType extends BaseModel
{
    
    protected $fillable = [
    	'sample_id',
        'name',
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
        return $this->belongsToMany('App\Asset')->orderBy('order');
    }
}
