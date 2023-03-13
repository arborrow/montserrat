<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tmp_offering_dedup', function (Blueprint $table) {
            $table->string('combo')->nullable()->default(null);
            $table->integer('contact_id')->nullable()->default(null);
            $table->integer('event_id')->nullable()->default(null);
            $table->integer('count')->default(0);
            $table->boolean('merged')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmp_offering_dedup');
    }
};
