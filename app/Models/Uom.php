<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Uom extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'uom';

    #[Scope]
    protected function active($query)
    {
        return $query->whereIsActive(1);
    }

    // scopes for various uom types based on uom.type enum
    //  $table->enum('type', ['Data', 'Time', 'Electric current','Length','Area','Volume','Mass','Temperature','Luminosity']);

    #[Scope]
    protected function time($query)
    {
        return $query->whereType('Time');
    }

    #[Scope]
    protected function data($query)
    {
        return $query->whereType('Data');
    }

    #[Scope]
    protected function electric($query)
    {
        return $query->whereType('Electric current');
    }

    #[Scope]
    protected function length($query)
    {
        return $query->whereType('Length');
    }

    #[Scope]
    protected function area($query)
    {
        return $query->whereType('Area');
    }

    #[Scope]
    protected function volume($query)
    {
        return $query->whereType('Volume');
    }

    #[Scope]
    protected function mass($query)
    {
        return $query->whereType('Mass');
    }

    // alias of scopeMass
    #[Scope]
    protected function weight($query)
    {
        return $query->whereType('Mass');
    }

    #[Scope]
    protected function temperature($query)
    {
        return $query->whereType('Temperature');
    }

    #[Scope]
    protected function luminosity($query)
    {
        return $query->whereType('Luminosity');
    }
}
