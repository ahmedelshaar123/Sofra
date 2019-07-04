<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model 
{

    protected $table = 'tokens';
    public $timestamps = true;
    protected $fillable = array('token', 'platform', 'tokenable_id', 'tokenable_type');
    protected $hidden = array('token');

    public function tokenable()
    {
        return $this->morphTo();
    }

}