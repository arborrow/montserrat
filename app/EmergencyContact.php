<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyContact extends Model
{
    use SoftDeletes; 
    protected $table = 'emergency_contact';
    protected $fillable = ['contact_id','name','relationship','phone','phone_alternate'];
}
