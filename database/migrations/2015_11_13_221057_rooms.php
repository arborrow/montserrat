<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned;
            $table->integer('building_id')->unsigned;
            $table->string('name');
            $table->text('description');
            $table->mediumText('notes');
            $table->string('access');
            $table->string('type');
            $table->string('occupancy');
            $table->string('status');
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
         Schema::drop('rooms');
    }
}
