<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddcolumnParticipant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participant', function ($table) {
            $table->datetime('registration_confirm_date')->nullable()->default(NULL);
            $table->datetime('attendance_confirm_date')->nullable()->default(NULL);
            $table->string('confirmed_by')->nullable()->default(NULL);
            $table->text('notes')->nullable()->default(NULL);
            $table->decimal('deposit',7,2)->default(0.00);
            $table->datetime('canceled_at')->nullable()->default(NULL);
            $table->datetime('arrived_at')->nullable()->default(NULL);
            $table->datetime('departed_at')->nullable()->default(NULL);
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
         Schema::table('participant', function ($table) {
            $table->dropColumn('registration_confirm_date');
            $table->dropColumn('attendance_confirm_date');
            $table->dropColumn('confirmed_by');
            $table->dropColumn('notes');
            $table->dropColumn('deposit');
            $table->dropColumn('canceled_at');
            $table->dropColumn('arrived_at');
            $table->dropColumn('departed_at');
            $table->dropColumn('room_id');
            $table->dropColumn('');
            });

    }
}