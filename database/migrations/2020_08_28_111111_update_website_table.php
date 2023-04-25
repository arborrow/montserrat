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
        Schema::table('website', function (Blueprint $table) {
            $table->string('description')->nullable();
            $table->integer('asset_id')->nullable();
            $table->index('asset_id', 'idx_asset_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['description', 'asset_id']);
            $table->dropIndex('idx_asset_id');
        });
    }
};
