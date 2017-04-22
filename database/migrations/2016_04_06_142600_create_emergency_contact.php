<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_contact', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->integer('contact_id');
            $table->string('name')->nullable()->default(null);
            $table->string('relationship')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('phone_alternate')->nullable()->default(null);
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
        Schema::drop('emergency_contact');
    }
}
