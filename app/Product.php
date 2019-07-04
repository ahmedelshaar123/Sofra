<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'preparing_time', 'image', 'restaurant_id', 'disabled');

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

}