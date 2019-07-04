<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model 
{

    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable = array('contactable_id', 'contactable_type', 'body', 'type');

    public function contactable()
    {
        return $this->morphTo();
    }

}