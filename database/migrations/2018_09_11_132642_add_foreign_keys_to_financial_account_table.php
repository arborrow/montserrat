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
        Schema::table('financial_account', function (Blueprint $table) {
            $table->foreign('contact_id')->references('id')->on('contact')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('parent_id')->references('id')->on('financial_account')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_account', function (Blueprint $table) {
            $table->dropForeign('financial_account_contact_id_foreign');
            $table->dropForeign('financial_account_parent_id_foreign');
        });
    }
};
