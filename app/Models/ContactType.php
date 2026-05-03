<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

#[Table('contact_type')]
class ContactType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    // generic organizations that are not dioceses, parishes, etc.
    #[Scope]
    protected function generic($query)
    {
        return $query->where([
            ['id', '>=', config('polanco.contact_type.province')],
            ['is_active', '=', true],
        ]);
    }
}
