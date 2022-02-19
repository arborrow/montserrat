<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('iso_code')->nullable();
            $table->string('country_code')->nullable();
            $table->integer('address_format_id')->nullable();
            $table->string('idd_prefix')->nullable();
            $table->string('ndd_prefix')->nullable();
            $table->integer('region_id')->nullable();
            $table->boolean('is_province_abbreviated')->default(0);
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
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
        Schema::dropIfExists('country');
    }
};
