<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Payment;

class StripePayout extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'stripe_payout';

    protected $fillable = ['payout_id', 'object', 'amount', 'arrival_date', 'date', 'status', 'total_fee_amount', 'reconcile_date'];

    protected function casts(): array
    {
        return [
            'arrival_date' => 'datetime',
            'date' => 'datetime',
            'reconcile_date' => 'datetime',
        ];
    }
    protected $appends = ['credit_card_total'];

    public function transactions(): HasMany
    {
        return $this->hasMany(StripeBalanceTransaction::class, 'payout_id', 'payout_id');
    }

    public function getUnreconciledCountAttribute()
    {
        $transactions = $this->transactions->whereNull('reconcile_date');

        return $transactions->count();
    }

    public function getCreditCardTotalAttribute()
    {
	    return Payment::where('payment_description', 'Credit card')->whereDate('payment_date', $this->date)->sum('payment_amount');
    }

    public function getIsUnreconciledAttribute()
    {
        return $this->amount != $this->credit_card_total;
    }
    public function scopeSinceConversionToStripe($query)
    {
        return $query->whereDate('arrival_date', '>=', '2022-06-15');
    }
}
