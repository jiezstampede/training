<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class TeamMemberSocial extends BaseModel
{
    
    protected $fillable = [
    	'team_member_id',
        'name',
        'icon_type',
        'icon_value',
        'icon_color',
        'link',
        'order',
        'published',
    	];
    
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }
}
