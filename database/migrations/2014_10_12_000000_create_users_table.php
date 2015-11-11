<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('suffix');
            $table->string('nickname');
            $table->string('spousename');
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
            $table->timestamp('firstvisit');
            $table->boolean('isbigdonor')->default(0);
            $table->boolean('isolddonor')->default(0);
            $table->boolean('isdirector')->default(0);
            $table->boolean('isinnkeeper')->default(0);
            $table->boolean('isassistant')->default(0);
            $table->boolean('iscaptain')->default(0);
            $table->boolean('isvolunteer')->default(0);
            $table->boolean('isemployee')->default(0);
            $table->mediumText('note1');
            $table->mediumText('note2');
            $table->boolean('hasspouse')->default(0);
            $table->boolean('isboardmember')->default(0);
            $table->boolean('donatedwillnotattend')->default(0);
            $table->boolean('reqremoval')->default(0);
            $table->string('email')->unique();
            $table->string('password', 60);
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
        Schema::drop('users');
    }
}
