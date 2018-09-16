<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCaptainRetreatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('captain_retreat', function(Blueprint $table)
		{
			$table->foreign('contact_id')->references('id')->on('contact')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('event_id')->references('id')->on('event')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('captain_retreat', function(Blueprint $table)
		{
			$table->dropForeign('captain_retreat_contact_id_foreign');
			$table->dropForeign('captain_retreat_event_id_foreign');
		});
	}

}
