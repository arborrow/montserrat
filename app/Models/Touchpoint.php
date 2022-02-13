<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Touchpoint extends Model implements Auditable
{
    use HasFactory;

    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $dates = [
        'touched_at',
    ];

    protected $fillable = ['person_id', 'staff_id', 'notes', 'type'];

    public function setTouchedAtAttribute($date)
    {
        $this->attributes['touched_at'] = Carbon::parse($date);
    }

    public function person()
    {
        return $this->belongsTo(Contact::class, 'person_id', 'id');
    }

    //alias for person
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'person_id', 'id');
    }

    public function staff()
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
