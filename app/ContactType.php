<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ContactType extends Model
{
    use SoftDeletes; 
    protected $table = 'contact_type';
    
}
