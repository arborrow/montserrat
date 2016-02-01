<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTouchpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('touchpoints', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('person_id')->unsigned;
            $table->integer('staff_id')->unsigned;
            $table->string('type');
            $table->mediumtext('notes');
            $table->timestamp('touched_at');
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
         Schema::drop('touchpoints'); 
    }
}
