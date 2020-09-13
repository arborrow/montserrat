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
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('type')->nullable();
            $table->integer('room_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->index(['type', 'name'], 'idx_type_name');
            $table->index('room_id', 'idx_room_id');
            $table->index('parent_id', 'idx_parent_id');
            $table->index('name', 'idx_name');
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
            $table->dropColumn(['label', 'latitude', 'longitude', 'type', 'room_id', 'parent_id']);
            $table->dropIndex('idx_type_name');
            $table->dropIndex('idx_room_id');
            $table->dropIndex('idx_parent_id');
            $table->dropIndex('idx_name');
        });
    }
}
