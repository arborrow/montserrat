<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'Donations_payment';

    protected $fillable = ['donation_id', 'payment_id', 'payment_amount', 'payment_description', 'cknumber', 'ccnumber', 'authorization_number', 'note', 'ty_letter_sent'];

    protected $primaryKey = 'payment_id';

    protected $casts = [
        'payment_date' => 'datetime',
        'expire_date' => 'datetime', 'payment_amount' => 'decimal:2',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id', 'donation_id');
    }

    public function balance_transaction()
    {
        return $this->belongsTo(StripeBalanceTransaction::class, 'stripe_balance_transaction_id', 'id');
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

    public function scopeFiltered($query, $filters)
    {   //initialize comparison operators to equals
        $payment_date_operator = '=';
        $payment_amount_operator = '=';

        //while not the most efficient - I want to get the comparison operators first so I can assign them to variables to use
        foreach ($filters->query as $filter => $value) {
            switch ($filter) {
                case 'payment_date_operator':
                    $payment_date_operator = ! empty($value) ? $value : '=';
                    break;
                case 'payment_amount_operator':
                    $payment_amount_operator = ! empty($value) ? $value : '=';
                    break;
            }
        }
        foreach ($filters->query as $filter => $value) {
            if ($filter == 'payment_date' && ! empty($value)) {
                $payment_date = Carbon::parse($value);
                $query->where($filter, $payment_date_operator, $payment_date);
            }
            if ($filter == 'payment_amount' && isset($value)) {
                $query->where($filter, $payment_amount_operator, $value);
            }
            if ($filter == 'payment_description' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'donation_description' && ! empty($value)) {
                $query->whereHas('Donation', function ($q) use ($value) {
                    $q->where('donation_description', '=', $value);
                });
            }
            if ($filter == 'note' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'ccnumber' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'cknumber' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
        }

        return $query;
    }
}
