<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'starting_at', 'ending_at', 'image', 'restaurant_id');
    protected $dates = ['starting_at','ending_at'];
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function getAvailableAttribute()
    {
        $today = Carbon::now()->startOfDay();
        if ($this->starting_at->startOfDay() <= $today && $this->ending_at->endOfDay() >= $today)
        {
            return true;
        }
        return false;
    }
}