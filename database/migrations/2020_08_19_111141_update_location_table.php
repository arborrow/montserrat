<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('label');
            $table->decimal('longitude', 11,8)->nullable();
            $table->decimal('latitude', 10,8)->nullable();
            $table->string('entity')->nullable();
            $table->integer('entity_id')->nullable();
            $table->integer('parent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['label', 'longitude', 'latitude','entity','entity_id','parent_id']);
        });
    }
}
