<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Retreatants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        Schema::create('retreatants', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned;
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
            $table->string('email')->unique();
            $table->string('gender');
            $table->integer('parish_id');
            $table->string('ethnicity')->default('Caucasian');
            $table->string('languages')->default('English');
            $table->Text('dietary');
            $table->Text('medical');
            $table->Text('roompreference');
            $table->mediumText('notes');
            $table->string('password', 60);
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
          Schema::drop('retreatants');
    }
}
