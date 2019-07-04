<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model 
{

    protected $table = 'payment_methods';
    public $timestamps = true;
    protected $fillable = array('name');

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}