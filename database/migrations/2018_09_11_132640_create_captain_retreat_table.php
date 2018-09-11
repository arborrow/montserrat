<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCaptainRetreatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('captain_retreat', function(Blueprint $table)
		{
			$table->integer('contact_id')->unsigned()->index();
			$table->integer('event_id')->unsigned()->index();
			$table->primary(['contact_id','event_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('captain_retreat');
	}

}
