<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_task', function (Blueprint $table) {
            $table->integer('frequency_interval')->nullable(false)->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_task', function (Blueprint $table) {
            $table->integer('frequency_interval')->nullable(true)->default(null)->change();
        });
    }
};
