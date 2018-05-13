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
    public function getRetreatOfferingAttribute()
    {
        return $this->payments()->first();
    }
    public function getPercentPaidAttribute() {
        if ($this->donation_amount > 0) {
            return ($this->payments->sum('payment_amount')/$this->donation_amount)*100;
        } else {
            return 0;
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

    
    
