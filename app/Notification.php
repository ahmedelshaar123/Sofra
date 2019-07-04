<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title', 'body', 'order_id', 'notifiable_id', 'notifiable_type');

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

}