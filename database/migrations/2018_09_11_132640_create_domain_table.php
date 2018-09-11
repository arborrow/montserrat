<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDomainTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('domain', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 64)->nullable()->index('UI_name');
			$table->string('description')->nullable();
			$table->text('config_backend', 65535)->nullable();
			$table->string('version', 32)->nullable();
			$table->integer('contact_id')->unsigned()->nullable()->index('domain_contact_id_foreign');
			$table->text('locales', 65535)->nullable();
			$table->text('locale_custom_strings', 65535)->nullable();
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
		Schema::drop('domain');
	}

}
