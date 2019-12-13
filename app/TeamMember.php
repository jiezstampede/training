<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends BaseModel
{
    
    protected $fillable = [
    	'name',
        'slug',
        'image',
        'background_image',
        'position',
        'description',
        'order',
        'published',
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
