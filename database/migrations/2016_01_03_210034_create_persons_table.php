<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('persons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned;
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
            $table->string('email')->unique()->nullable()->default(NULL);
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->integer('parish_id')->nullable()->unsigned();
            $table->string('ethnicity')->default('Caucasian')->nullable();
            $table->string('languages')->default('English')->nullable();
            $table->Text('dietary')->nullable();
            $table->Text('medical')->nullable();
            $table->Text('roompreference')->nullable();
            $table->mediumText('notes')->nullable();
            $table->boolean('is_donor')->default('1')->nullable();
            $table->boolean('is_retreatant')->default('1')->nullable();
            $table->boolean('is_director')->default('0')->nullable();
            $table->boolean('is_innkeeper')->default('0')->nullable();
            $table->boolean('is_assistant')->default('0')->nullable();
            $table->boolean('is_captain')->default('0')->nullable();
            $table->boolean('is_staff')->default('0')->nullable();
            $table->boolean('is_volunteer')->default('0')->nullable();
            $table->boolean('is_board')->default('0')->nullable();
            $table->boolean('is_pastor')->default('0')->nullable();
            $table->boolean('is_bishop')->default('0')->nullable();
            $table->boolean('is_catholic')->default('1')->nullable();
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
        Schema::drop('persons');
    }
}
