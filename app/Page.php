<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Page extends BaseModel
{
    
    protected $fillable = [
    	'name',
        'slug',
        'published',
        'page_category_id',
        'content',
    	];
    
    public function pageCategory()
    {
        return $this->belongsTo('App\PageCategory');
    }

    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }
}
