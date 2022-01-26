<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_processor', function (Blueprint $table) {
            $table->foreign('payment_processor_type_id')->references('id')->on('payment_processor_type')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_processor', function (Blueprint $table) {
            $table->dropForeign('payment_processor_payment_processor_type_id_foreign');
        });
    }
};
