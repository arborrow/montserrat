<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retreatant extends Model
{
  protected $dates = ['created_at', 'updated_at', 'disabled_at'];  //
  
  public function registrations() {
        return $this->hasMany('\App\Registration','id','retreat_id');
    }  //
}
