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
            $table->integer('contact_id')->nullable()->default(NULL);
            $table->integer('location_type_id')->nullable()->default(NULL);
            $table->integer('is_primary')->default(0);
            $table->integer('is_billing')->default(0);
            $table->integer('mobile_provider_id')->nullable()->default(NULL);
            $table->string('phone')->nullable()->default(NULL);
            $table->string('phone_ext')->nullable()->default(NULL);
            $table->string('phone_numeric')->nullable()->default(NULL);
            $table->integer('phone_type_id')->nullable()->default(NULL);
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
