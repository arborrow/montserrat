<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('title')->nullable();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('suffix')->nullable();
            $table->string('nickname')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable()->default('TX');
            $table->string('zip')->nullable();
            $table->string('country')->nullable()->default('USA');
            $table->string('homephone')->nullable();
            $table->string('workphone')->nullable();
            $table->string('url')->nullable();
            $table->string('mobilephone')->nullable();
            $table->string('faxphone')->nullable();
            $table->string('emergencycontactname')->nullable();
            $table->string('emergencycontactphone')->nullable();
            $table->string('emergencycontactphone2')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->integer('parish_id')->unsigned()->nullable();
            $table->string('ethnicity')->nullable()->default('Unspecified');
            $table->string('languages')->nullable()->default('English');
            $table->text('dietary', 65535)->nullable();
            $table->text('medical', 65535)->nullable();
            $table->text('roompreference', 65535)->nullable();
            $table->text('notes', 16777215)->nullable();
            $table->boolean('is_donor')->nullable()->default(1);
            $table->boolean('is_retreatant')->nullable()->default(1);
            $table->boolean('is_director')->nullable()->default(0);
            $table->boolean('is_innkeeper')->nullable()->default(0);
            $table->boolean('is_assistant')->nullable()->default(0);
            $table->boolean('is_captain')->nullable()->default(0);
            $table->boolean('is_staff')->nullable()->default(0);
            $table->boolean('is_volunteer')->nullable()->default(0);
            $table->boolean('is_board')->nullable()->default(0);
            $table->boolean('is_pastor')->nullable()->default(0);
            $table->boolean('is_bishop')->nullable()->default(0);
            $table->boolean('is_catholic')->nullable()->default(1);
            $table->string('password', 60);
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->boolean('is_deceased')->default(0);
            $table->integer('donor_id')->nullable()->unique();
            $table->boolean('is_formerboard')->nullable()->default(0);
            $table->boolean('is_jesuit')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('persons');
    }
}
