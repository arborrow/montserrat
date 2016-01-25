<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetreatsTable extends Migration
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
            $table->integer('idnumber')->unsigned;
            $table->string('title');
            $table->mediumtext('description');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->string('type');
            $table->boolean('silent');
            $table->decimal('amount',6,2);
            $table->integer('year')->unsigned;
            $table->integer('attending')->unsigned;
            $table->integer('directorid')->unsigned;
            $table->integer('innkeeperid')->unsigned;
            $table->integer('assistantid')->unsigned;
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
        Schema::drop('retreats'); //
        
    }
}
