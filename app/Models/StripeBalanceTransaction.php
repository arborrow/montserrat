<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class StripeBalanceTransaction extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'stripe_balance_transaction';

    protected $casts = [
        'payout_date' => 'datetime',
        'available_date' => 'datetime',
        'reconcile_date' => 'datetime',
    ];  //

    protected $fillable = ['balance_transaction_id', 'payout_id', 'customer_id', 'charge_id', 'total_amount', 'fee_amount', 'net_amount', 'payout_date', 'available_date', 'reconcile_date'];

    public function payout()
    {
        return $this->hasOne(StripePayout::class, 'id', 'payout_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'stripe_balance_transaction_id', 'id');
    }

}

