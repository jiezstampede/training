<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PageItem extends BaseModel
{
    
    protected $fillable = [
    	'page_id',
        'slug',
        'title',
        'value',
        'description',
        'image',
        'order',
        'json_data',
		];
	public function asset()
    {
		return $this->hasOne('App\Asset', 'id', 'image');
	}
}
