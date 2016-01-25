<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('roomstates', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('room_id')->unsigned;
            $table->timestamp('statechange_at');
            $table->string('statusfrom');
            $table->string('statusto');
            $table->softDeletes();
            $table->timestamps();
           
        //
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
           Schema::drop('roomstates');
    }
}
