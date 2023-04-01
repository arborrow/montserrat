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
        Schema::create('squarespace_custom_form_field', function (Blueprint $table) {
            $table->id();
            $table->integer('form_id')->index('idx_form_id');
            $table->string('name');
            $table->integer('sort_order')->nullable();
            $table->string('type');
            $table->string('variable_name');
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
        Schema::dropIfExists('squarespace_custom_form_field');
    }
};
