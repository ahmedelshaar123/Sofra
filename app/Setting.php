<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('about_app', 'conditions_and_rules', 'facebook_url', 'twitter_url', 'instagram_url', 'commission', 'accounts');

}