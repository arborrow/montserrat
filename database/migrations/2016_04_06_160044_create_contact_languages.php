<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_languages', function (Blueprint $table) {
            $table->increments('id')->unsigned;
            $table->integer('contact_id')->unsigned;
            $table->integer('language_id')->unsigned;
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::drop('contact_languages');
    }
}
