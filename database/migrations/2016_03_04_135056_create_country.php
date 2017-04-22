<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('country', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('name')->nullable()->default(null);
            $table->string('iso_code')->nullable()->default(null);
            $table->string('country_code')->nullable()->default(null);
            $table->integer('address_format_id')->nullable()->default(null);
            $table->string('idd_prefix')->nullable()->default(null);
            $table->string('ndd_prefix')->nullable()->default(null);
            $table->integer('region_id')->nullable()->default(null);
            $table->boolean('is_province_abbreviated')->default(0);
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
        Schema::drop('country');
    }
}
