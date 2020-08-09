<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonationType extends Model
{
    use SoftDeletes;
    protected $table = 'donation_type';

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }
}
