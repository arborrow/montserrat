<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRetreatmastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retreatmasters', function (Blueprint $table) {
            $table->bigInteger('person_id')->unsigned()->index();
            $table->integer('retreat_id')->unsigned()->index();
            $table->primary(['person_id', 'retreat_id']);
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
