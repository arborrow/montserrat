<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinancialTrxnTable extends Migration
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
            $table->integer('from_financial_account_id')->unsigned()->nullable()->index('financial_trxn_from_financial_account_id_foreign');
            $table->integer('to_financial_account_id')->unsigned()->nullable()->index('financial_trxn_to_financial_account_id_foreign');
            $table->dateTime('trxn_date');
            $table->decimal('total_amount', 20)->nullable();
            $table->decimal('fee_amount', 20)->nullable();
            $table->decimal('net_amount', 20)->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('trxn_id')->nullable();
            $table->string('trxn_result_code')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('payment_processor_id')->unsigned()->nullable()->index('UI_ftrxn_payment_instrument_id');
            $table->integer('payment_instrument_id')->unsigned()->nullable();
            $table->string('check_number')->nullable()->index('UI_ftrxn_check_number');
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
        Schema::dropIfExists('financial_trxn');
    }
}
