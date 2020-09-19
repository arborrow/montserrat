<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoomNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function ($table) {
            $table->text('notes', 16777215)->nullable()->change();
            $table->text('description', 65535)->nullable()->change();
            $table->string('access')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('occupancy')->nullable()->change();
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function ($table) {
            $table->text('notes', 16777215)->nullable(false)->change();
            $table->text('description', 65535)->nullable(false)->change();
            $table->string('access')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
            $table->string('occupancy')->nullable(false)->change();
            $table->string('status')->nullable(false)->change();
        });
    }
}
