<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Touchpoint extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    //
    use SoftDeletes;

    protected $fillable = ['person_id', 'staff_id', 'notes', 'type'];

    protected function casts(): array
    {
        return [
            'touched_at' => 'datetime',
        ];
    }

    public function setTouchedAtAttribute($date)
    {
        $this->attributes['touched_at'] = Carbon::parse($date);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'person_id', 'id');
    }

    //alias for person
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'person_id', 'id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'staff_id', 'id');
    }

    public function getContactSubtypeAttribute()
    {
        if (isset($this->person->subcontacttype->name)) {
            return $this->person->subcontacttype->name;
        } else {
            return;
        }
    }

    public function missingRegistrationEmail($contact, $retreat)
    {
        return ! $this->where('person_id', $contact)->where('notes', 'like', $retreat.' registration email sent.')->first();
    }
}
