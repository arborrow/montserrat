<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('roomstates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id');
            $table->dateTime('statechange_at')->default('0000-00-00 00:00:00');
            $table->string('statusfrom');
            $table->string('statusto');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('roomstates');
    }
};
