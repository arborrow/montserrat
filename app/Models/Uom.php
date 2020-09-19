<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Uom extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'uom';

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    // scopes for various uom types based on uom.type enum
    //  $table->enum('type', ['Data', 'Time', 'Electric current','Length','Area','Volume','Mass','Temperature','Luminosity']);

    public function scopeTime($query)
    {
        return $query->whereType('Time');
    }

    public function scopeData($query)
    {
        return $query->whereType('Data');
    }

    public function scopeElectric($query)
    {
        return $query->whereType('Electric current');
    }

    public function scopeLength($query)
    {
        return $query->whereType('Length');
    }

    public function scopeArea($query)
    {
        return $query->whereType('Area');
    }

    public function scopeVolume($query)
    {
        return $query->whereType('Volume');
    }

    public function scopeMass($query)
    {
        return $query->whereType('Mass');
    }

    // alias of scopeMass
    public function scopeWeight($query)
    {
        return $query->whereType('Mass');
    }

    public function scopeTemperature($query)
    {
        return $query->whereType('Temperature');
    }

    public function scopeLuminosity($query)
    {
        return $query->whereType('Luminosity');
    }
}
