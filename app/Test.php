<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Test extends BaseModel
{
    
    protected $fillable = [
    	'name',
        'slug',
        'date',
        'tinyint',
        'order',
        'integer',
        'image',
        'image_thumbnail',
        'enum',
        'text',
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
}
