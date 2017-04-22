<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('county', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('name')->nullable()->default(null);
            $table->string('abbreviation')->nullable()->default(null);
            $table->integer('state_province_id')->nullable()->default(null);
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
        Schema::drop('county');
    }
}
