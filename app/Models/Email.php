<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Email extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'email';

    protected $fillable = ['contact_id', 'location_type_id', 'is_primary', 'email'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationType::class, 'location_type_id', 'id');
    }

    public function getLocationTypeNameAttribute()
    {
        if (isset($this->location_type_id) && isset($this->location->name)) {
            return $this->location->name;
        } else {
            return;
        }
    }
}
