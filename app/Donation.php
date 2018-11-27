<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;
    protected $table = 'Donations';
    protected $fillable =  ['donation_id', 'donor_id', 'donation_description', 'donation_amount','payment_description','Notes','contact_id'];
    protected $dates = ['deleted_at','created_at','updated_at','start_date','end_date','donation_date'];
    protected $primaryKey = "donation_id";
    
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'donation_id', 'donation_id');
    }
    public function retreat()
    {
        return $this->hasOne(Retreat::class, 'id', 'event_id');
    }
    public function getDonationStartDate() {
        if (isset($this->start_date)) {
            return $this->start_date->format('m/d/Y');
        } else {
            return NULL;
        }
    }
    public function getDonationEndDate() {
        if (isset($this->end_date)) {
            return $this->end_date->format('m/d/Y');
        } else {
            return NULL;
        }
    }
    public function getRetreatOfferingAttribute()
    {
        return $this->payments()->first();
    }
    public function getPercentPaidAttribute() {
        if ($this->donation_amount > 0) {
            return number_format(($this->payments->sum('payment_amount')/$this->donation_amount),2)*100;
        } else {
            return 0;
        }
    }
    public function getPaymentsPaidAttribute() {
        if (isset($this->payments)) {
            return ($this->payments->sum('payment_amount'));
        } else {
            return 0;
        }
    }
    public function getRetreatNameAttribute() {
        if (isset($this->retreat->title)) {
            return $this->retreat->title;
        } else {
            return NULL;
        }
    }
    public function getRetreatIdnumberAttribute() {
        if (isset($this->retreat->idnumber)) {
            return $this->retreat->idnumber;
        } else {
            return NULL;
        }
    }
    public function getRetreatStartDateAttribute() {
        if (isset($this->retreat->start_date)) {
            return $this->retreat->start_date->format('m/d/Y');
        } else {
            return NULL;
        }
    }
    public function getRetreatLinkAttribute() {
        if (isset($this->retreat->title)) {
            $path = url('retreat/'.$this->retreat->id);
            return "<a href='".$path."'>".'#'.$this->retreat_idnumber.' - '.$this->retreat_name."</a>";
        }
    }
    public function getDonationDateFormattedAttribute() {
        if (isset($this->donation_date)) {
            return $this->donation_date->format('m/d/Y'); 
        } else {
            return NULL;
        }
    }
    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a donation to cascade to children so payments are also deleted
        static::deleted(function($donation)
        {
            $donation->payments()->delete();
        });
    }    

}

    
    
