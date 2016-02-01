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
            $table->Timestamp('canceled_at')->nullable()->default(NULL);
            $table->Timestamp('arrived_at')->nullable()->default(NULL);
            $table->Timestamp('departed_at')->nullable()->default(NULL);
            $table->Integer('room_id')->unsigned()->nullable()->default(NULL);
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
