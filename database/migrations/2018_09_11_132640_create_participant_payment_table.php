<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participant_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('participant_id')->unsigned()->index('participant_payment_participant_id_foreign');
            $table->integer('contribution_id')->unsigned();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->unique(['contribution_id', 'participant_id'], 'UI_contribution_participant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_payment');
    }
};
