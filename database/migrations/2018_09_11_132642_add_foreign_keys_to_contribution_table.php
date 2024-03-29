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
        Schema::table('contribution', function (Blueprint $table) {
            $table->foreign('address_id')->references('id')->on('address')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('contact_id')->references('id')->on('contact')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('honor_type_id')->references('id')->on('contact')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contribution', function (Blueprint $table) {
            $table->dropForeign('contribution_address_id_foreign');
            $table->dropForeign('contribution_contact_id_foreign');
            $table->dropForeign('contribution_honor_type_id_foreign');
        });
    }
};
