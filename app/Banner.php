<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Asset;

class Banner extends BaseModel
{
    
    protected $fillable = [
    	'name',
        'caption',
        'published',
        'order',
        'image',
        'image_thumbnail',
        'link',
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

    // public function getImageThumbnailAttribute($value)
    // {
    //     if (empty($this->image_thumbnail)) {
    //         return Asset::findOrFail($this->image)->path;
    //     } 
    //     return $value;
    // }
}
