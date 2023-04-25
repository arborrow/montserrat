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
        Schema::table('asset_task', function (Blueprint $table) {
            $table->integer('frequency_interval')->nullable(false)->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_task', function (Blueprint $table) {
            $table->integer('frequency_interval')->nullable(true)->default(null)->change();
        });
    }
};
