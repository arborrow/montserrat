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
    
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'donation_id', 'donation_id');
    }

}

    
    
