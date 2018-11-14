<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class AssetGroupItem extends BaseModel
{

    protected $fillable = [
    	'asset_id',
        'group_id',
        'order',
    	];

    public $timestamps = false;

    public function asset()
	{
		return $this->hasOne('App\Asset', 'id', 'asset_id');
	}
}

