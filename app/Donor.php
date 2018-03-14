<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class Donor extends Model
{
    //use SoftDeletes;
    protected $table = 'Donors';
    protected $primaryKey = 'donor_id';
    public $timestamps = false;
}
