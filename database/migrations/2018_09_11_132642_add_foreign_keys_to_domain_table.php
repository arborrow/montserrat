<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDomainTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('domain', function(Blueprint $table)
		{
			$table->foreign('contact_id')->references('id')->on('contact')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('domain', function(Blueprint $table)
		{
			$table->dropForeign('domain_contact_id_foreign');
		});
	}

}
