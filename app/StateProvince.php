<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateProvince extends Model
{
    use SoftDeletes;
    protected $table = 'state_province';
}
