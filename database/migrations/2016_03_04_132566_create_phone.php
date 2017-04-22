<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('phone', function (Blueprint $table) {
            $table->BigIncrements('id')->unsigned;
            $table->integer('contact_id')->nullable()->default(null);
            $table->integer('location_type_id')->nullable()->default(null);
            $table->integer('is_primary')->default(0);
            $table->integer('is_billing')->default(0);
            $table->integer('mobile_provider_id')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('phone_ext')->nullable()->default(null);
            $table->string('phone_numeric')->nullable()->default(null);
            $table->integer('phone_type_id')->nullable()->default(null);
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
        Schema::drop('phone');
    }
}
