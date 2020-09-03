<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('room_id');
            $table->integer('registration_id');
            $table->integer('retreatant_id');
            $table->integer('retreat_id');
            $table->integer('group_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->text('notes', 65535);
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
