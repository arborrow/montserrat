<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactReferral extends Model
{
    use SoftDeletes;
    protected $table = 'contact_referral';
}
