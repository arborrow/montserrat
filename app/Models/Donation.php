<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Donation extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'Donations';
    protected $fillable = ['donation_id', 'donor_id', 'donation_description', 'donation_amount', 'payment_description', 'Notes', 'contact_id'];
    protected $dates = ['start_date', 'end_date', 'donation_date'];
    protected $primaryKey = 'donation_id';
    protected $appends = ['payments_paid'];
    protected $casts = ['donation_amount' => 'decimal:2', 'donation_install' => 'decimal:2'];

    public function generateTags(): array
    {
        return [
                $this->contact->sort_name,
                $this->RetreatIdnumber,
            ];
    }

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

    public function description()
    {
        return $this->hasOne(DonationType::class, 'name', 'donation_description');
    }

    public function getDonationStartDate()
    {
        if (isset($this->start_date)) {
            return $this->start_date->format('m/d/Y');
        } else {
            return;
        }
    }

    public function getDonationEndDate()
    {
        if (isset($this->end_date)) {
            return $this->end_date->format('m/d/Y');
        } else {
            return;
        }
    }

    public function getRetreatOfferingAttribute()
    {
        return $this->payments()->first();
    }

    public function getPercentPaidAttribute()
    {
        if ($this->donation_amount > 0) {
            return number_format((($this->payments_paid / $this->donation_amount) * 100), 0);
        } else {
            return 0;
        }
    }

    public function getPaymentsPaidAttribute()
    {
        if (isset($this->payments)) {
            return $this->payments->sum('payment_amount');
        } else {
            return 0;
        }
    }

    public function getRetreatNameAttribute()
    {
        if (isset($this->retreat->title)) {
            return $this->retreat->title;
        } else {
            return;
        }
    }

    public function getDonorFullnameAttribute()
    {
        if (isset($this->contact->full_name)) {
            return $this->contact->full_name;
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

            return "<a href='".$path."'>".'#'.$this->retreat_idnumber.' - '.$this->retreat_name.'</a>';
        }
    }

    public function getDonationDateFormattedAttribute()
    {
        if (isset($this->donation_date)) {
            return $this->donation_date->format('m/d/Y');
        } else {
            return;
        }
    }

    public function getDonationThankYouSentAttribute()
    {
        if (isset($this['Thank You'])) {
            return $this['Thank You'];
        } else {
            return 'N';
        }
    }

    public static function boot()
    {
        parent::boot();

        // cause a delete of a donation to cascade to children so payments are also deleted
        static::deleted(function ($donation) {
            $donation->payments()->delete();
        });
    }
}
