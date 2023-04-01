<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->required();
            $table->string('label')->required();
            $table->string('type')->required();
            $table->text('fields', 65535)->nullable();
            $table->text('filters', 65535)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('last_run_date')->nullable();
            $table->dateTime('next_scheduled_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_list');
    }
};
