<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContributionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contribution', function (Blueprint $table) {
            $table->foreign('address_id')->references('id')->on('address')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('contact_id')->references('id')->on('contact')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('honor_type_id')->references('id')->on('contact')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contribution', function (Blueprint $table) {
            $table->dropForeign('contribution_address_id_foreign');
            $table->dropForeign('contribution_contact_id_foreign');
            $table->dropForeign('contribution_honor_type_id_foreign');
        });
    }
}
