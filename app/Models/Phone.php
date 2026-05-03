<?php

namespace App\Models;

use App\Traits\PhoneTrait;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

#[Table('phone')]
#[Fillable('contact_id', 'location_type_id', 'is_primary', 'phone', 'phone_type')]
class Phone extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use PhoneTrait;
    use SoftDeletes;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationType::class, 'location_type_id', 'id');
    }

    public function getPhoneExtensionAttribute()
    {
        if (empty($this->phone_ext)) {
            return;
        } else {
            return ','.$this->phone_ext;
        }
    }

    public function getLocationTypeNameAttribute()
    {
        if (isset($this->location_type_id) && isset($this->location->name)) {
            return $this->location->name;
        } else {
            return;
        }
    }

    public function setPhoneAttribute($phone)
    {
        $clean_phone = $this->format_phone($phone);

        if (empty($clean_phone['phone_extension'])) {
            $this->attributes['phone'] = $clean_phone['phone_formatted'];
            $this->attributes['phone_numeric'] = $clean_phone['phone_numeric'];
        } else {
            $this->attributes['phone'] = $clean_phone['phone_formatted'];
            $this->attributes['phone_ext'] = $clean_phone['phone_extension'];
            $this->attributes['phone_numeric'] = $clean_phone['phone_numeric'];
        }
    }
}
