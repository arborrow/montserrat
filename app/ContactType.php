<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ContactType extends Model
{
    use SoftDeletes;
    protected $table = 'contact_type';
    
    //generic organizations that are not dioceses, parishes, etc.
    public function scopeGeneric($query)
    {
        return $query->where([
            ['id','>=',config('polanco.contact_type.province')],
            ['is_active','=',true],
        ]);
    }
}
