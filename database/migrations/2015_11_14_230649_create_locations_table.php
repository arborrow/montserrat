<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
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
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->integer('occupancy')->nullable();
            $table->mediumText('notes')->nullable();
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
        Schema::drop('locations');
    }
}
