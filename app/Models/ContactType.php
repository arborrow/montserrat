<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ContactType extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'contact_type';

    //generic organizations that are not dioceses, parishes, etc.
    public function scopeGeneric($query)
    {
        return $query->where([
            ['id', '>=', config('polanco.contact_type.province')],
            ['is_active', '=', true],
        ]);
    }
}
