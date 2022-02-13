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
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->nullable()->index();
            $table->integer('location_type_id')->nullable();
            $table->integer('is_primary')->nullable()->default(0);
            $table->integer('is_billing')->nullable()->default(0);
            $table->string('street_address')->nullable();
            $table->integer('street_number')->nullable();
            $table->string('street_number_suffix')->nullable();
            $table->string('street_number_predirectional')->nullable();
            $table->string('street_name')->nullable();
            $table->string('street_type')->nullable();
            $table->string('street_number_postdirectional')->nullable();
            $table->string('street_unit')->nullable();
            $table->string('supplemental_address_1')->nullable();
            $table->string('supplemental_address_2')->nullable();
            $table->string('supplemental_address_3')->nullable();
            $table->string('city')->nullable();
            $table->integer('county_id')->nullable();
            $table->integer('state_province_id')->nullable();
            $table->string('postal_code_suffix')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('usps_adc')->nullable();
            $table->integer('country_id')->nullable();
            $table->float('geo_code_1', 10, 0)->nullable();
            $table->float('geo_code_2', 10, 0)->nullable();
            $table->integer('manual_geo_code')->nullable()->default(0);
            $table->string('timezone')->nullable();
            $table->string('name')->nullable();
            $table->integer('master_id')->nullable();
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
        Schema::dropIfExists('address');
    }
};
