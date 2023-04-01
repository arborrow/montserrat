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
        Schema::create('retreat_names', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('title', 52)->nullable();
            $table->string('start', 16)->nullable();
            $table->string('end', 16)->nullable();
            $table->string('idnumber', 4)->nullable();
            $table->string('ppd_id', 15)->nullable()->unique('idx_ppdid');
            $table->string('polanco_id', 15)->nullable()->unique('idx_polanco_id');
            $table->string('type', 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('retreat_names');
    }
};
