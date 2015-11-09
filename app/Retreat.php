<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Retreat extends Model
{
    
  protected $dates = ['start', 'end', 'created_at', 'updated_at', 'disabled_at'];  //
  public function setStartAttribute($date) {
      $this->attributes['start'] = Carbon::parse($date);
  }
  public function setEndAttribute($date) {
      $this->attributes['end'] = Carbon::parse($date);
  }
}
