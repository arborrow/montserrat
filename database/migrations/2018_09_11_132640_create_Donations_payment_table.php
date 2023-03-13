<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Donations_payment', function (Blueprint $table) {
            $table->integer('payment_id', true);
            $table->integer('donation_id')->nullable()->index();
            $table->integer('stripe_balance_transaction_id')->nullable()->index('idx_stripe_balance_transaction_id');
            $table->decimal('payment_amount', 13, 2)->default('0.00');
            $table->dateTime('payment_date')->nullable()->index('payment_date');
            $table->string('payment_description', 23)->nullable();
            $table->string('cknumber', 17)->nullable();
            $table->string('ccnumber', 21)->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->string('authorization_number', 8)->nullable();
            $table->string('note', 100)->nullable();
            $table->string('ty_letter_sent', 1)->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Donations_payment');
    }
};
