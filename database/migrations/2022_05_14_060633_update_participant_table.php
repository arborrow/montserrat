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
        Schema::table('participant', function (Blueprint $table) {
            $table->integer('order_id')->nullable();
            $table->index('order_id', 'idx_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participant', function (Blueprint $table) {
            $table->dropColumn(['order_id']);
            $table->dropIndex('idx_order_id');
        });
    }
};
