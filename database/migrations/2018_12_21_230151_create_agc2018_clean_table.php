<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgc2018CleanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agc2018_clean', function(Blueprint $table)
		{
			$table->integer('contact_id')->primary();
			$table->string('prefix', 9)->nullable();
			$table->string('firstname', 19)->nullable();
			$table->string('lastname', 29)->nullable();
			$table->string('display_name', 40)->nullable();
			$table->string('sort_name', 42)->nullable();
			$table->string('street_address', 49)->nullable();
			$table->string('supplemental_address_1', 23)->nullable();
			$table->string('city', 23)->nullable();
			$table->string('state', 2)->nullable();
			$table->string('postal_code', 10)->nullable();
			$table->string('household_name', 50)->nullable();
			$table->date('last_event')->nullable();
			$table->date('last_payment')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agc2018_clean');
	}

}
