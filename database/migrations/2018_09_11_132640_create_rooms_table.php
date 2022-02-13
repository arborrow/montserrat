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
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('location_id');
            $table->integer('floor')->nullable()->default(null);
            $table->string('name');
            $table->text('description', 65535);
            $table->text('notes', 16777215);
            $table->string('access');
            $table->string('type');
            $table->string('occupancy');
            $table->string('status');
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
