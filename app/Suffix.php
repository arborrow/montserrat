<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suffix extends Model
{
    use SoftDeletes;
    protected $table = 'suffix';
}
