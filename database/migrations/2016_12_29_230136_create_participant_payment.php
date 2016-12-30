<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('participant_id')->unsigned;
            $table->integer('contribution_id')->unsigned;
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->unique(['contribution_id','participant_id'],'UI_contribution_participant');
            //$table->foreign('participant_id')->references('id')->on('participant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('participant_payment');
    }
}
