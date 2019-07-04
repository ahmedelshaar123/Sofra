<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'district_id', 'email', 'password', 'min_charge', 'delivery_fees', 'phone', 'whatsapp', 'image', 'pin_code', 'api_token', 'is_acitve', 'availability');
    protected $hidden = array('password', 'api_token', 'pin_code');

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function offers()
    {
        return $this->hasMany('App\Offer');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }

    public function tokens()
    {
        return $this->morphMany('App\Token', 'tokenable');
    }

    public function contacts()
    {
        return $this->morphMany('App\Contact', 'contactable');
    }

}