<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('address', function (Blueprint $table) {
            $table->increments('id')->unsigned;
            $table->integer('contact_id')->nullable()->default(null);
            $table->integer('location_type_id')->nullable()->default(null);
            $table->integer('is_primary')->nullable()->default(0);
            $table->integer('is_billing')->nullable()->default(0);
            $table->string('street_address')->nullable()->default(null);
            $table->integer('street_number')->nullable()->default(null);
            $table->string('street_number_suffix')->nullable()->default(null);
            $table->string('street_number_predirectional')->nullable()->default(null);
            $table->string('street_name')->nullable()->default(null);
            $table->string('street_type')->nullable()->default(null);
            $table->string('street_number_postdirectional')->nullable()->default(null);
            $table->string('street_unit')->nullable()->default(null);
            $table->string('supplemental_address_1')->nullable()->default(null);
            $table->string('supplemental_address_2')->nullable()->default(null);
            $table->string('supplemental_address_3')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->integer('county_id')->nullable()->default(null);
            $table->integer('state_province_id')->nullable()->default(null);
            $table->string('postal_code_suffix')->nullable()->default(null);
            $table->string('postal_code')->nullable()->default(null);
            $table->string('usps_adc')->nullable()->default(null);
            $table->integer('country_id')->nullable()->default(null);
            $table->double('geo_code_1')->nullable()->default(null);
            $table->double('geo_code_2')->nullable()->default(null);
            $table->integer('manual_geo_code')->nullable()->default(0);
            $table->string('timezone')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->integer('master_id')->nullable()->default(null);
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
         Schema::drop('address');
    }
}
