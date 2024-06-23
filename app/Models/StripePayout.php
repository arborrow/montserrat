<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

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
