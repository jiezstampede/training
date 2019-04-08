<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Page extends BaseModel
{
    
    protected $fillable = [
    	'name',
        'slug',
        'value',
        'title',
        'blurb',
        'description',
        'button_caption',
        'button_link',
        'image',
        'video',
        'yt_video',
        'content',
        'icon_type',
        'icon_value',
        'json_data',
        'published',
    	];
    
    public function pageCategory()
    {
        return $this->belongsTo('App\PageCategory');
    }

    public function seo()
    {
        return $this->morphOne('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }

    public function image()
	{
		return $this->hasOne('App\Asset', 'id', 'image');
    }

    public function assetGroups()
    {
        return $this->morphMany('App\AssetGroup', 'reference');
    }
    
    public function video()
	{
		return $this->hasOne('App\Asset', 'id', 'video');
	}
}
