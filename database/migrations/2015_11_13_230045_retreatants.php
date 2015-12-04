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
            $table->bigInteger('person_id')->unsigned;
            $table->string('title')->nullable();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('suffix')->nullable();
            $table->string('nickname')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->default('TX')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->default('USA')->nullable();
            $table->string('homephone')->nullable();
            $table->string('workphone')->nullable();
            $table->string('url')->nullable();
            $table->string('mobilephone')->nullable();
            $table->string('faxphone')->nullable();
            $table->string('emergencycontactname')->nullable();
            $table->string('emergencycontactphone')->nullable();
            $table->string('emergencycontactphone2')->nullable();
            $table->string('email')->unique();
            $table->string('gender')->nullable();
            $table->integer('parish_id')->nullable()->unsigned();
            $table->string('religion')->default('Catholic')->nullable();
            $table->string('ethnicity')->default('Caucasian')->nullable();
            $table->string('languages')->default('English')->nullable();
            $table->Text('dietary')->nullable();
            $table->Text('medical')->nullable();
            $table->Text('roompreference')->nullable();
            $table->mediumText('notes')->nullable();
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
