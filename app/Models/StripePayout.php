<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

#[Table('stripe_payout')]
#[Fillable('payout_id', 'object', 'amount', 'arrival_date', 'date', 'status', 'total_fee_amount', 'reconcile_date')]
class StripePayout extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'arrival_date' => 'datetime',
            'date' => 'datetime',
            'reconcile_date' => 'datetime',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(StripeBalanceTransaction::class, 'payout_id', 'payout_id');
    }

    public function getUnreconciledCountAttribute()
    {
        $transactions = $this->transactions->whereNull('reconcile_date');

        return $transactions->count();
    }
}
