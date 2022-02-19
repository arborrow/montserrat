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
        Schema::create('Retreats', function (Blueprint $table) {
            $table->integer('retreat_id')->nullable()->unique('idx_retreat_id');
            $table->integer('Year')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('idnumber', 60)->nullable()->index('idx_retreat_number');
            $table->string('retreat_name', 150)->nullable();
            $table->integer('NumberAttended')->nullable();
            $table->string('retreat_master', 100)->nullable();
            $table->integer('retreat_type_id')->nullable();
            $table->integer('event_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Retreats');
    }
};
