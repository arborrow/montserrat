<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Buildings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned;
            $table->string('name');
            $table->text('description');
            $table->integer('datecontructed');
            $table->text('notes');
            $table->string('access');
            $table->string('type');
            $table->string('occupancy');
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
          Schema::drop('locations');
    }
}
