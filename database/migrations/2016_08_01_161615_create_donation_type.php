<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationType extends Migration
{
    /**
     * Run the migrations.
     * Loosely based on CiviCRM option_value table that stores event types
     * @return void
     */
    public function up()
    {
        Schema::create('donation_type', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('label');
            $table->string('value');
            $table->string('name')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->boolean('is_default')->nullable()->default(0);
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(1);
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
            Schema::drop('donation_type'); //
    }
}
