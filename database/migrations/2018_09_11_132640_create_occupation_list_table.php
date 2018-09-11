<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOccupationListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occupation_list', function(Blueprint $table)
		{
			$table->string('OCC_CODE', 15)->nullable();
			$table->string('OCC_TITLE', 105)->nullable();
			$table->string('OCC_GROUP', 15)->nullable();
			$table->string('TOT_EMP', 15)->nullable();
			$table->decimal('EMP_PRSE', 3, 1)->nullable();
			$table->string('H_MEAN', 15)->nullable();
			$table->string('A_MEAN', 15)->nullable();
			$table->decimal('MEAN_PRSE', 3, 1)->nullable();
			$table->string('H_MEDIAN', 15)->nullable();
			$table->string('A_MEDIAN', 15)->nullable();
			$table->string('ANNUAL', 15)->nullable();
			$table->string('HOURLY', 15)->nullable();
			$table->integer('ocuupation_id')->nullable()->comment('fk to ppd occupation id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('occupation_list');
	}

}
