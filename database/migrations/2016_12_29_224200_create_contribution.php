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
            $table->integer('financial_type_id')->nullable()->unsigned()->default(null);
            $table->integer('contribution_page_id')->unsigned()->nullable()->default(null);
            $table->integer('payment_instrument_id')->nullable()->unsigned()->default(null);
            $table->datetime('receive_date')->nullable()->default(null);
            $table->decimal('non_deductible_amount', 20, 2)->nullable()->default(0.00);
            $table->decimal('total_amount', 20, 2);
            $table->decimal('fee_amount', 20, 2)->nullable()->default(null);
            $table->decimal('net_amount', 20, 2)->nullable()->default(null);
            $table->string('trxn_id')->nullable()->default(null);
            $table->string('invoice_id')->nullable()->default(null);
            $table->string('currency', 3)->nullable()->default(null);
            $table->datetime('cancel_date')->nullable()->default(null);
            $table->text('cancel_reason')->nullable()->default(null);
            $table->datetime('receipt_date')->nullable()->default(null);
            $table->datetime('thankyou_date')->nullable()->default(null);
            $table->string('source')->nullable()->default(null);
            $table->text('amount_level')->nullable()->default(null);
            $table->integer('contribution_recur_id')->nullable()->unsigned()->default(null);
            $table->integer('honor_contact_id')->unsigned()->nullable()->default(null);
            $table->boolean('is_test')->nullable()->default(0);
            $table->boolean('is_pay_later')->nullable()->default(0);
            $table->integer('contribution_status_id')->unsigned()->nullable()->default(1);
            $table->integer('honor_type_id')->unsigned()->nullable()->default(null);
            $table->integer('address_id')->unsigned()->nullable()->default(null);
            $table->string('check_number')->nullable()->default(null);
            $table->integer('campaign_id')->unsigned()->nullable()->default(null);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->unique('trxn_id', 'UI_contrib_trxn_id');
            $table->unique('invoice_id', 'UI_contrib_invoice_id');
            $table->index('payment_instrument_id', 'UI_contrib_payment_instrument_id');
            $table->index('contribution_status_id', 'index_contribution_status');
            $table->index('receive_date', 'received_date');
            $table->index('check_number', 'check_number');
            $table->foreign('contact_id')->references('id')->on('contact');
            // $table->foreign('financial_type_id')->references('id')->on('financial_type');
            // $table->foreign('contribution_page_id')->references('id')->on('contribution_page');
            // $table->foreign('contribution_recur_id')->references('id')->on('contribution_recur');
            $table->foreign('honor_type_id')->references('id')->on('contact');
            $table->foreign('address_id')->references('id')->on('address');
            // $table->foreign('campaign_id')->references('id')->on('campaign');
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
