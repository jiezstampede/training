<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends BaseModel
{
    
    protected $fillable = [
    	'number',

        'order_id',

        'order_number',

        'seller_sku',

        'lazada_sku',

        'details',

        'shipping_provider',

        'delivery_status',

        'unit_price',

        'payment_fee',

        'shipping_paid',

        'shipping_charged',

        'promotions',

        'other_credits',
        'remarks',
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
        return $this->hasMany('App\Transaction', 'order_item_number', 'number');
    }
}
