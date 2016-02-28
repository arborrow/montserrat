<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetreatmastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('retreatmasters', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('retreat_id')->unsigned;
            $table->integer('retreatmaster_id')->unsigned;
            $table->index('retreat_id');
            $table->index('retreatmaster_id');
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
        Schema::drop('retreatmasters'); 
    }
}
