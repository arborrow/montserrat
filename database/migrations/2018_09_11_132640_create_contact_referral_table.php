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
        Schema::create('contact_referral', function (Blueprint $table) {
            $table->integer('contact_id');
            $table->integer('referral_id');
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->unique(['contact_id', 'referral_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_referral');
    }
};
