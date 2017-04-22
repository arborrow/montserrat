<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event', function ($table) {
            $table->string('type')->nullable()->default(null);
            $table->boolean('silent')->nullable()->default(null);
            $table->decimal('amount', 6, 2)->nullable()->default(null);
            $table->integer('year')->unsigned()->nullable()->default(null);
            $table->integer('attending')->unsigned()->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event', function ($table) {
            $table->dropColumn('type');
            $table->dropColumn('silent');
            $table->dropColumn('amount');
            $table->dropColumn('year');
            $table->dropColumn('attending');
        });
    }
}
