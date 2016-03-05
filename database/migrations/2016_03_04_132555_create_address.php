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
            $table->integer('contact_id')->nullable()->default(NULL);
            $table->integer('location_type_id')->nullable()->default(NULL);
            $table->integer('is_primary')->nullable()->default(0);
            $table->integer('is_billing')->nullable()->default(0);
            $table->string('street_address')->nullable()->default(NULL);
            $table->integer('street_number')->nullable()->default(NULL);
            $table->string('street_number_suffix')->nullable()->default(NULL);
            $table->string('street_number_predirectional')->nullable()->default(NULL);
            $table->string('street_name')->nullable()->default(NULL);
            $table->string('street_type')->nullable()->default(NULL);
            $table->string('street_number_postdirectional')->nullable()->default(NULL);
            $table->string('street_unit')->nullable()->default(NULL);
            $table->string('supplemental_address_1')->nullable()->default(NULL);
            $table->string('supplemental_address_2')->nullable()->default(NULL);
            $table->string('supplemental_address_3')->nullable()->default(NULL);
            $table->string('city')->nullable()->default(NULL);
            $table->integer('county_id')->nullable()->default(NULL);
            $table->integer('state_province_id')->nullable()->default(NULL);
            $table->string('postal_code_suffix')->nullable()->default(NULL);
            $table->string('postal_code')->nullable()->default(NULL);
            $table->string('usps_adc')->nullable()->default(NULL);
            $table->integer('country_id')->nullable()->default(NULL);
            $table->double('geo_code_1')->nullable()->default(NULL);
            $table->double('geo_code_2')->nullable()->default(NULL);
            $table->integer('manual_geo_code')->nullable()->default(0);
            $table->string('timezone')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->integer('master_id')->nullable()->default(NULL);
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
