<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContributionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contribution', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contact_id')->unsigned()->index('contribution_contact_id_foreign');
			$table->integer('financial_type_id')->unsigned()->nullable();
			$table->integer('contribution_page_id')->unsigned()->nullable();
			$table->integer('payment_instrument_id')->unsigned()->nullable()->index('UI_contrib_payment_instrument_id');
			$table->dateTime('receive_date')->nullable()->index('received_date');
			$table->decimal('non_deductible_amount', 20)->nullable()->default(0.00);
			$table->decimal('total_amount', 20);
			$table->decimal('fee_amount', 20)->nullable();
			$table->decimal('net_amount', 20)->nullable();
			$table->string('trxn_id')->nullable()->unique('UI_contrib_trxn_id');
			$table->string('invoice_id')->nullable()->unique('UI_contrib_invoice_id');
			$table->string('currency', 3)->nullable();
			$table->dateTime('cancel_date')->nullable();
			$table->text('cancel_reason', 65535)->nullable();
			$table->dateTime('receipt_date')->nullable();
			$table->dateTime('thankyou_date')->nullable();
			$table->string('source')->nullable();
			$table->text('amount_level', 65535)->nullable();
			$table->integer('contribution_recur_id')->unsigned()->nullable();
			$table->integer('honor_contact_id')->unsigned()->nullable();
			$table->boolean('is_test')->nullable()->default(0);
			$table->boolean('is_pay_later')->nullable()->default(0);
			$table->integer('contribution_status_id')->unsigned()->nullable()->default(1)->index('index_contribution_status');
			$table->integer('honor_type_id')->unsigned()->nullable()->index('contribution_honor_type_id_foreign');
			$table->integer('address_id')->unsigned()->nullable()->index('contribution_address_id_foreign');
			$table->string('check_number')->nullable()->index('check_number');
			$table->integer('campaign_id')->unsigned()->nullable();
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
		Schema::drop('contribution');
	}

}
