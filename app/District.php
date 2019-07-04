<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model 
{

    protected $table = 'districts';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id');

    public function clients()
    {
        return $this->hasMany('App\Client');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

}