<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retreat extends Model
{
  protected $dates = ['start', 'end', 'created_at', 'updated_at', 'disabled_at'];  //
}
