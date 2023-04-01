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
        Schema::create('stripe_payout', function (Blueprint $table) {
            $table->id();
            $table->string('payout_id')->index('payout_id');
            $table->string('object');
            $table->decimal('amount', 13, 2)->default('0.00');
            $table->dateTime('arrival_date')->nullable()->index('arrival_date');
            $table->dateTime('date')->nullable();
            $table->string('status')->nullable();
            $table->decimal('total_fee_amount', 13, 2)->default('0.00');
            $table->integer('fee_payment_id')->nullable()->index('idx_fee_payment_id');
            $table->dateTime('reconcile_date')->nullable();
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
