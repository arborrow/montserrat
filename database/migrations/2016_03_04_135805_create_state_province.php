<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateProvince extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('state_province', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('name')->nullable()->default(null);
            $table->string('abbreviation')->nullable()->default(null);
            $table->Integer('country_id')->nullable()->default(null);
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
        Schema::drop('state_province');
    }
}
