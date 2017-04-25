<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    
class LocationType extends Model
{
    use SoftDeletes;
    protected $table = 'location_type';
}
