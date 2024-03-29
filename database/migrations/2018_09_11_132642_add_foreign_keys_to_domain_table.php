<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('domain', function (Blueprint $table) {
            $table->foreign('contact_id')->references('id')->on('contact')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('domain', function (Blueprint $table) {
            $table->dropForeign('domain_contact_id_foreign');
        });
    }
};
