<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Assistants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('assistants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default('0');
            $table->string('title');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('suffix');
            $table->string('nickname');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('state')->default('TX');
            $table->string('zip');
            $table->string('country')->default('USA');
            $table->string('homephone');
            $table->string('workphone');
            $table->string('url');
            $table->string('mobilephone');
            $table->string('faxphone');
            $table->string('emergencycontactname');
            $table->string('emergencycontactphone');
            $table->string('emergencycontactphone2');
            $table->string('gender');
            $table->string('ethnicity')->default('Caucasian');
            $table->string('languages')->default('English');
            $table->mediumText('note1');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('active')->default('1');
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
        //
        Schema::drop('assistants');
    }
}
