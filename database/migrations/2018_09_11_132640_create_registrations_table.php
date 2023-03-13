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
        Schema::create('registrations', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('retreatant_id')->unsigned();
            $table->integer('retreat_id')->unsigned();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->dateTime('register')->nullable();
            $table->dateTime('confirmregister')->nullable();
            $table->dateTime('confirmattend')->nullable();
            $table->string('confirmedby')->nullable();
            $table->text('notes', 65535);
            $table->decimal('deposit', 7);
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->dateTime('canceled_at')->nullable();
            $table->dateTime('arrived_at')->nullable();
            $table->dateTime('departed_at')->nullable();
            $table->integer('room_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
