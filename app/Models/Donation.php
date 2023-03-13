<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $primaryKey = 'donation_id';

    protected $appends = ['payments_paid'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'donation_date' => 'datetime', 'donation_amount' => 'decimal:2', 'donation_install' => 'decimal:2',
    ];

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

    public function getDonationStartDateAttribute()
    {
        if (isset($this->start_date)) {
            return $this->start_date->format('m/d/Y');
        } else {
            return;
        }
    }

    public function getDonationEndDateAttribute()
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

    public function getDonationSummaryAttribute()
    {
        $idnumber = (isset($this->retreat_idnumber)) ? ' - #'.$this->retreat_idnumber : null;

        return $this->donation_date_formatted.' - '.
            $this->donation_description.' - $'.
            number_format($this->payments_paid, 2).' / $'.
            number_format($this->donation_amount, 2).' ('.
            number_format($this->percent_paid, 0).'%)'.
            $idnumber;
    }

    public function getDonationThankYouSentAttribute()
    {
        if (isset($this['Thank You'])) {
            return $this['Thank You'];
        } else {
            return 'N';
        }
    }

    public function scopeFiltered($query, $filters)
    {   //initialize comparison operators to equals
        $donation_date_operator = '=';
        $donation_amount_operator = '=';
        $start_date_only_operator = '=';
        $end_date_only_operator = '=';
        $donation_install_operator = '=';

        //while not the most efficient - I want to get the comparison operators first so I can assign them to variables to use
        foreach ($filters->query as $filter => $value) {
            switch ($filter) {
                case 'donation_date_operator':
                    $donation_date_operator = ! empty($value) ? $value : '=';
                    break;
                case 'donation_amount_operator':
                    $donation_amount_operator = ! empty($value) ? $value : '=';
                    break;
                case 'start_date_only_operator':
                    $start_date_only_operator = ! empty($value) ? $value : '=';
                    break;
                case 'end_date_only_operator':
                    $end_date_only_operator = ! empty($value) ? $value : '=';
                    break;
                case 'donation_install_operator':
                    $donation_install_operator = ! empty($value) ? $value : '=';
                    break;
            }
        }
        foreach ($filters->query as $filter => $value) {
            if ($filter == 'donation_date' && ! empty($value)) {
                $donation_date = Carbon::parse($value);
                $query->where($filter, $donation_date_operator, $donation_date);
            }
            if ($filter == 'donation_amount' && isset($value)) {
                $query->where($filter, $donation_amount_operator, $value);
            }
            if ($filter == 'start_date_only' && ! empty($value)) {
                $start_date_only = Carbon::parse($value);
                $query->where('start_date', $start_date_only_operator, $start_date_only);
            }
            if ($filter == 'end_date_only' && ! empty($value)) {
                $end_date_only = Carbon::parse($value);
                $query->where('end_date', $end_date_only_operator, $end_date_only);
            }
            if ($filter == 'donation_install' && ! empty($value)) {
                $query->where($filter, $donation_install_operator, $value);
            }
            if ($filter == 'donation_install' && ! empty($value)) {
                $query->where($filter, $donation_install_operator, $value);
            }
            if ($filter == 'donation_description' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'event_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'notes1' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'notes' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'terms' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'stripe_invoice' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'donation_thank_you' && ! empty($value)) {
                if ($value == 'Y') {
                    $query->where('Thank You', '=', $value);
                } else {
                    $query->where('Thank You', '=', null);
                }
            }
        }

        return $query;
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
