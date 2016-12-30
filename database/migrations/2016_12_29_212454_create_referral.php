<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral', function (Blueprint $table) {
            $table->increments('id')->unsigned;
            $table->string('name');
            $table->boolean('is_active')->nullable()->default(0);
            $table->boolean('is_default')->nullable()->default(0);
            $table->integer('weight')->nullable()->default(NULL)->unsigned;
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
        Schema::drop('referral', function (Blueprint $table) {
            //
        });
    }
}
