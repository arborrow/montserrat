<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialTrxn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_trxn', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_financial_account_id')->unsigned()->nullable()->default(null);
            $table->integer('to_financial_account_id')->unsigned()->nullable()->default(null);
            $table->dateTime('trxn_date');
            $table->decimal('total_amount', 20, 2)->nullable()->default(null);
            $table->decimal('fee_amount', 20, 2)->nullable()->default(null);
            $table->decimal('net_amount', 20, 2)->nullable()->default(null);
            $table->string('currency', 3)->nullable()->default(null);
            $table->string('trxn_id')->nullable()->default(null);
            $table->string('trxn_result_code')->nullable()->default(null);
            $table->integer('status_id')->unsigned()->nullable()->default(null);
            $table->integer('payment_processor_id')->unsigned()->nullable()->default(null)->index('UI_ftrxn_payment_instrument_id');
            $table->integer('payment_instrument_id')->unsigned()->nullable()->default(null);
            $table->string('check_number')->nullable()->default(null)->index('UI_ftrxn_check_number');
            $table->timestamps();
            $table->foreign('from_financial_account_id')->references('id')->on('financial_account');
            $table->foreign('to_financial_account_id')->references('id')->on('financial_account');
            $table->foreign('payment_processor_id')->references('id')->on('payment_processor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('financial_trxn');
    }
}
