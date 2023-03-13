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
        Schema::table('participant_payment', function (Blueprint $table) {
            $table->foreign('contribution_id')->references('id')->on('contribution')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('participant_id')->references('id')->on('participant')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('participant_payment', function (Blueprint $table) {
            $table->dropForeign('participant_payment_contribution_id_foreign');
            $table->dropForeign('participant_payment_participant_id_foreign');
        });
    }
};
