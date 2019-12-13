<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class AssetSamplesType extends BaseModel
{
    
    protected $fillable = [
    	'asset_id',
        'samples_type_id',
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
}
