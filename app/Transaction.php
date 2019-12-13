<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Transaction extends BaseModel
{
    
    protected $fillable = [
    	'number',
        'date',
        'type',
        'fee_name',
        'amount',
        'vat',
        'wht',
        'paid_status',
        'order_number',
        'order_item_number',
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
