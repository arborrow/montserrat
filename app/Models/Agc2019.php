<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Agc2019 extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'agc_household_name';

    protected $fillable = ['contact_id'];

    protected $primaryKey = 'contact_id';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'last_event' => 'datetime',
            'last_payment' => 'datetime',
        ];
    }
}
