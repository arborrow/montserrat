<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetreats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('retreats', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('idnumber');
            $table->string('title');
            $table->string('description');
            $table->bigInteger('start');
            $table->bigInteger('end');
            $table->string('type');
            $table->boolean('silent');
            $table->decimal('amount',6,2);
            $table->integer('year');
            $table->integer('directorid');
            $table->integer('innkeeperid');
            $table->integer('assistantid');
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
        Schema::drop('retreats'); //
        
    }
}
