<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',64)->nullable()->default(NULL)->index('UI_name');
            $table->string('description')->nullable()->default(NULL);
            $table->text('config_backend')->nullable()->default(NULL);
            $table->string('version',32)->nullable()->default(NULL);
            $table->integer('contact_id')->unsigned()->nullable()->default(NULL);
            $table->text('locales')->nullable()->default(NULL);
            $table->text('locale_custom_strings')->nullable()->default(NULL);
            $table->timestamps();
            $table->foreign('contact_id')->references('id')->on('contact');
            
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
