<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVrmasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vrmaster', function (Blueprint $table) {
            $table->string('email_address', 40)->index('email_address');
            $table->string('first_name', 25)->nullable();
            $table->string('last_name', 48)->nullable();
            $table->string('title', 47)->nullable();
            $table->string('address_1', 66)->nullable();
            $table->string('address_2', 24)->nullable();
            $table->string('city', 27)->nullable();
            $table->string('state', 5)->nullable();
            $table->string('postalcode', 10)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('work_phone', 18)->nullable();
            $table->string('home_phone', 14)->nullable();
            $table->string('mobile_phone', 14)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('Suffix', 5)->nullable();
            $table->string('MiddleName', 15)->nullable();
            $table->string('Salutation', 29)->nullable();
            $table->string('Name', 53)->nullable();
            $table->string('optin_status', 17)->nullable();
            $table->string('optin_status_last_updated', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vrmaster');
    }
}
