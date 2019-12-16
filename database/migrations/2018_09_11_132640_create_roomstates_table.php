<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roomstates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id');
            $table->dateTime('statechange_at')->default('0000-00-00 00:00:00');
            $table->string('statusfrom');
            $table->string('statusto');
            $table->softDeletes();
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
        Schema::drop('roomstates');
    }
}
