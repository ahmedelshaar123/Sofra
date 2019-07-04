<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array( 'restaurant_id', 'notes', 'state', 'client_id', 'payment_method_id', 'cost', 'delivery_fees', 'total_price', 'commission', 'net');

    public function paymentMethod()
    {
        return $this->belongsTo('App\PaymentMethod');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

}