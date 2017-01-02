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
            $table->integer('from_financial_account_id')->unsigned()->nullable()->default(NULL);
            $table->integer('to_financial_account_id')->unsigned()->nullable()->default(NULL);
            $table->dateTime('trxn_date');
            $table->decimal('total_amount',20,2)->nullable()->default(NULL);
            $table->decimal('fee_amount',20,2)->nullable()->default(NULL);
            $table->decimal('net_amount',20,2)->nullable()->default(NULL);
            $table->string('currency',3)->nullable()->default(NULL);
            $table->string('trxn_id')->nullable()->default(NULL);
            $table->string('trxn_result_code')->nullable()->default(NULL);
            $table->integer('status_id')->unsigned()->nullable()->default(NULL);
            $table->integer('payment_processor_id')->unsigned()->nullable()->default(NULL)->index('UI_ftrxn_payment_instrument_id');
            $table->integer('payment_instrument_id')->unsigned()->nullable()->default(NULL);
            $table->string('check_number')->nullable()->default(NULL)->index('UI_ftrxn_check_number');
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
