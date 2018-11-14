<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Email extends BaseModel
{
    
    protected $fillable = [
    	'subject',
        'to',
        'cc',
        'bcc',
        'from_email',
        'from_name',
        'replyTo',
        'content',
        'attach',
        'status',
        'sent',
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
