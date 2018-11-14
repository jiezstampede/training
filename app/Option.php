<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	protected $fillable = [
	'name',
	'slug',
	'type',
	'value',
	'asset',
	'category',
	];

	public function scopeSlug($query, $slug)
	{
		return $query->whereSlug($slug)->first();
	}

	public function image()
	{
		return $this->hasOne('App\Asset', 'id','asset');
	}
}
