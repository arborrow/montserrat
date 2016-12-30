<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactReferral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_referral', function (Blueprint $table) {
            $table->integer('contact_id')->unsigned;
            $table->integer('referral_id')->unsigned;
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->unique(['contact_id','referral_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contact_referral', function (Blueprint $table) {
            //
        });
    }
}
