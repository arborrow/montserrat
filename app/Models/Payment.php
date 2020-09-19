<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends Model implements Auditable
{
    use HasFactory;

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'Donations_payment';
    protected $fillable = ['donation_id', 'payment_id', 'payment_amount', 'payment_description', 'cknumber', 'ccnumber', 'authorization_number', 'note', 'ty_letter_sent'];
    protected $dates = [
        'payment_date', 'expire_date',
    ];
    protected $primaryKey = 'payment_id';
    protected $casts = ['payment_amount'=>'decimal:2'];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id', 'donation_id');
    }

    public function getPaymentNumberAttribute()
    {
        if (! is_null($this->ccnumber)) {
            return $this->ccnumber;
        }

        if (! is_null($this->cknumber)) {
            return $this->cknumber;
        } else {
            return;
        }
    }

    public function getPaymentDateFormattedAttribute()
    {
        if (isset($this->payment_date)) {
            return $this->payment_date->format('m/d/Y');
        } else {
            return;
        }
    }

    public function getDonationAmountAttribute()
    {
        if (isset($this->donation->donation_amount)) {
            return number_format($this->donation->donation_amount, 2);
        } else {
            return 0;
        }
    }
}
