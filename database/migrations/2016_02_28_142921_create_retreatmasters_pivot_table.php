<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetreatmastersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retreatmasters', function (Blueprint $table) {
            $table->BigInteger('person_id')->unsigned()->index();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
            $table->integer('retreat_id')->unsigned()->index();
            $table->foreign('retreat_id')->references('id')->on('retreats')->onDelete('cascade');
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
