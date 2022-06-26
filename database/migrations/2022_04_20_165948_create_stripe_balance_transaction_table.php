<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_balance_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('payout_id')->index('payout_id');
            $table->string('balance_transaction_id')->index('balance_transaction_id');;
            $table->string('customer_id')->index('customer_id');
            $table->string('charge_id')->index('charge_id');
            $table->dateTime('payout_date')->nullable()->index('payout_date');;
            $table->string('description');
            $table->string('note');
            $table->string('type');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('zip');
            $table->string('cc_last_4');
            $table->decimal('total_amount', 13, 2)->default('0.00');
            $table->decimal('fee_amount', 13, 2)->default('0.00');
            $table->decimal('net_amount', 13, 2)->default('0.00');
            $table->integer('payment_id')->nullable()->index('idx_payment_id');
            $table->dateTime('reconcile_date')->nullable();
            $table->dateTime('available_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_payout');
    }
};
