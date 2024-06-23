<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class StripeBalanceTransaction extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'stripe_balance_transaction';

    protected $fillable = ['balance_transaction_id', 'payout_id', 'customer_id', 'charge_id', 'total_amount', 'fee_amount', 'net_amount', 'payout_date', 'available_date', 'reconcile_date'];

    protected function casts(): array
    {
        return [
            'payout_date' => 'datetime',
            'available_date' => 'datetime',
            'reconcile_date' => 'datetime',
        ];
    }

    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function payout(): HasOne
    {
        return $this->hasOne(StripePayout::class, 'id', 'payout_id');
    }

    public function squarespace_order(): HasOne
    {
        return $this->hasOne(SquarespaceOrder::class, 'stripe_charge_id', 'charge_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'stripe_balance_transaction_id', 'id');
    }
}
