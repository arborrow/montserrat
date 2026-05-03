<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

#[Table('agc_household_name', 'contact_id')]
#[WithoutTimestamps]
#[Fillable('contact_id')]
class Agc2019 extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected function casts(): array
    {
        return [
            'last_event' => 'datetime',
            'last_payment' => 'datetime',
        ];
    }
}
