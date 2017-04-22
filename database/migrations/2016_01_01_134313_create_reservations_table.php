<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned;
            $table->integer('room_id');
            $table->integer('registration_id');
            $table->integer('retreatant_id');
            $table->integer('retreat_id');
            $table->integer('group_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->text('notes');
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
         Schema::drop('reservations');
    }
}
