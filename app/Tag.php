<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Tag extends BaseModel
{

    protected $fillable = [
    	'name',
        'taggable_id',
        'taggable_type',
    	];


    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }
}

