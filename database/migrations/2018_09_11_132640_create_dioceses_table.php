<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiocesesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dioceses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('address1');
			$table->string('address2');
			$table->string('city');
			$table->string('state');
			$table->string('zip');
			$table->string('phone');
			$table->string('fax');
			$table->string('email');
			$table->string('webpage');
			$table->string('bishop_id');
			$table->text('notes', 65535);
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
		Schema::drop('dioceses');
	}

}
