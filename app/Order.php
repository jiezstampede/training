<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    
    protected $fillable = [
    	'number',

        'date',

        'subtotal',

        'shipping_paid',

        'shipping_charged',

        'payment_fee',

        'total',
    	];
    
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'order_number', 'number');
    }
}
