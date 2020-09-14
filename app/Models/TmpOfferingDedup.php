<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class TmpOfferingDedup extends Model
{
    use HasFactory;

    //use SoftDeletes;
    protected $table = 'tmp_offering_dedup';
    protected $fillable = ['contact_id', 'event_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function retreat()
    {
        return $this->hasOne(Retreat::class, 'id', 'event_id');
    }

    public function getRetreatNameAttribute()
    {
        if (isset($this->retreat->title)) {
            return $this->retreat->title;
        } else {
            return;
        }
    }

    public function getRetreatIdnumberAttribute()
    {
        if (isset($this->retreat->idnumber)) {
            return $this->retreat->idnumber;
        } else {
            return;
        }
    }

    public function getRetreatStartDateAttribute()
    {
        if (isset($this->retreat->start_date)) {
            return $this->retreat->start_date->format('m/d/Y');
        } else {
            return;
        }
    }

    public function getRetreatLinkAttribute()
    {
        if (isset($this->retreat->title)) {
            $path = url('retreat/'.$this->retreat->id);

            return "<a href='".$path."'>".$this->retreat_name.'</a>';
        }
    }

    public static function boot()
    {
        parent::boot();
    }
}
