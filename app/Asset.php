<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function tags()
    {
        return $this->morphMany('App\Tag', 'taggable');
    }
}
