<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Email extends Model implements Auditable
{
    use HasFactory;

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'email';
    protected $fillable = ['contact_id', 'location_type_id', 'is_primary', 'email'];

    public function owner()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id', 'id');
    }
}
