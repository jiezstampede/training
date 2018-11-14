<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Article extends BaseModel
{
    
    protected $fillable = [
    	'name',
        'slug',
        'blurb',
        'date',
        'featured',
        'published',
        'content',
        'image',
        'image_thumbnail',
        'author',
    	];
    
 	public function asset()
	{
		return $this->hasOne('App\Asset', 'id', 'image');
	}
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }
    
    public function tags()
    {
        return $this->morphMany('App\Tag', 'taggable');
    }
}
