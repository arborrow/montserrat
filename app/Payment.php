<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
   use SoftDeletes;
   protected $table = 'Donations_payment';
   protected $fillable =  ['donation_id', 'payment_id', 'payment_amount', 'payment_description','cknumber','ccnumber','authorization_number','note','ty_letter_sent'];
   protected $dates = ['deleted_at','created_at','updated_at','payment_date','expire_date'];
   protected $primaryKey = 'payment_id';
     
   public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id', 'donation_id');
    }
    
    public function getPaymentNumberAttribute() {
        if (!is_null($this->ccnumber)) { 
            return $this->ccnumber;
        }
        
        if (!is_null($this->cknumber)) {
            return $this->cknumber;
        } else {
            return NULL;
        }
      
    
    }

}
