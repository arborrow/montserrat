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
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('room_id');
            $table->integer('registration_id');
            $table->integer('retreatant_id');
            $table->integer('retreat_id');
            $table->integer('group_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->text('notes', 65535);
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
