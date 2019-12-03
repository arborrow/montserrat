<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactType extends Model
{
    use SoftDeletes;
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
