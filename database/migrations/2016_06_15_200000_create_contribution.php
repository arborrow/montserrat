<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContribution extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribution', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->integer('financial_type_id')->nullable()->unsigned()->default(NULL);
            $table->integer('contribution_page_id')->unsigned()->nullable()->default(NULL);
            $table->integer('payment_instrument_id')->nullable()->unsigned()->default(NULL);
            $table->datetime('receive_date')->nullable()->default(NULL);
            $table->decimal('non_deductible_amount',20,2)->nullable()->default(0.00);
            $table->decimal('total_amount',20,2);
            $table->decimal('fee_amount',20,2)->nullable()->default(NULL);
            $table->decimal('net_amount',20,2)->nullable()->default(NULL);
            $table->string('trxn_id')->nullable()->default(NULL);
            $table->string('invoice_id')->nullable()->default(NULL);
            $table->string('currency',3)->nullable()->default(NULL);
            $table->datetime('cancel_date')->nullable()->default(NULL);
            $table->text('cancel_reason')->nullable()->default(NULL);
            $table->datetime('receipt_date')->nullable()->default(NULL);
            $table->datetime('thankyou_date')->nullable()->default(NULL);
            $table->string('source')->nullable()->default(NULL);
            $table->text('amount_level')->nullable()->default(NULL);
            $table->integer('contribution_recur_id')->nullable()->unsigned()->default(NULL);
            $table->integer('honor_contact_id')->unsigned()->nullable()->default(NULL);
            $table->boolean('is_test')->nullable()->default(0);
            $table->boolean('is_pay_later')->nullable()->default(0);
            $table->integer('contribution_status_id')->unsigned()->nullable()->default(1);
            $table->integer('honor_type_id')->unsigned()->nullable()->default(NULL);
            $table->integer('address_id')->unsigned()->nullable()->default(NULL);
            $table->string('check_number')->nullable()->default(NULL);
            $table->integer('campaign_id')->unsigned()->nullable()->default(NULL);
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::drop('contribution'); 
    }
}
