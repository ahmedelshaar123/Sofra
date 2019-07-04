<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model 
{

    protected $table = 'transactions';
    public $timestamps = true;
    protected $fillable = array('amount', 'note', 'restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

}