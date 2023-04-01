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
        Schema::table('financial_trxn', function (Blueprint $table) {
            $table->foreign('from_financial_account_id')->references('id')->on('financial_account')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('payment_processor_id')->references('id')->on('payment_processor')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('to_financial_account_id')->references('id')->on('financial_account')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_trxn', function (Blueprint $table) {
            $table->dropForeign('financial_trxn_from_financial_account_id_foreign');
            $table->dropForeign('financial_trxn_payment_processor_id_foreign');
            $table->dropForeign('financial_trxn_to_financial_account_id_foreign');
        });
    }
};
