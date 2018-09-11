<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Donations', function(Blueprint $table)
		{
			$table->integer('donation_id', true);
			$table->integer('donor_id')->nullable();
			$table->string('donation_description', 100)->nullable();
			$table->dateTime('donation_date')->nullable();
			$table->float('donation_amount', 10, 0)->nullable();
			$table->float('donation_install', 10, 0)->nullable();
			$table->text('terms', 65535)->nullable();
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->string('payment_description', 100)->nullable();
			$table->integer('retreat_id')->nullable();
			$table->text('Notes', 65535)->nullable();
			$table->text('Notes1', 65535)->nullable();
			$table->char('Notice', 1)->nullable();
			$table->string('Arrupe Donation Description', 100)->nullable();
			$table->integer('Target Amount')->nullable();
			$table->integer('Donation Type ID')->nullable();
			$table->char('Thank You', 1)->nullable();
			$table->string('AGC Donation Description', 100)->nullable();
			$table->string('Pledge', 50)->nullable();
			$table->integer('contact_id')->nullable();
			$table->softDeletes();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->integer('event_id')->nullable()->index('event_id');
			$table->integer('ppd_id')->nullable()->index('ppd_id');
			$table->index(['donor_id','donation_id'], 'idx_donor-donation_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Donations');
	}

}
