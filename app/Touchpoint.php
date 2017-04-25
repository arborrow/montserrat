<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Touchpoint extends Model
{
    //
    use SoftDeletes;
    protected $table = 'touchpoints';
    protected $dates = ['touched_at', 'created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['person_id','staff_id','notes','type'];

    public function setTouchedAtAttribute($date)
    {
        $this->attributes['touched_at'] = Carbon::parse($date);
    }
    
    public function person()
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
            return null;
        }
    }
}
