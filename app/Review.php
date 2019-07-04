<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model 
{

    protected $table = 'reviews';
    public $timestamps = true;
    protected $fillable = array('rating', 'comment', 'client_id', 'restaurant_id');

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

}