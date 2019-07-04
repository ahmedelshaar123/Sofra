<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'image', 'email', 'phone', 'district_id', 'description', 'password', 'is_active', 'pin_code', 'api_token');
    protected $hidden = array('password', 'api_token', 'pin_code');

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
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