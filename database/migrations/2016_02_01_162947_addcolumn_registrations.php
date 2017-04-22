<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddcolumnRegistrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        //
        Schema::table('registrations', function ($table) {
            $table->Timestamp('canceled_at')->nullable()->default(null);
            $table->Timestamp('arrived_at')->nullable()->default(null);
            $table->Timestamp('departed_at')->nullable()->default(null);
            $table->Integer('room_id')->unsigned()->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('registrations', function ($table) {
            $table->dropColumn('canceled_at');
            $table->dropColumn('arrived_at');
            $table->dropColumn('departed_at');
            $table->dropColumn('room_id');
        });
    }
}
