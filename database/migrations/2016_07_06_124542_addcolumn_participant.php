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
            $table->datetime('registration_confirm_date')->nullable()->default(null);
            $table->datetime('attendance_confirm_date')->nullable()->default(null);
            $table->string('confirmed_by')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->decimal('deposit', 7, 2)->default(0.00);
            $table->datetime('canceled_at')->nullable()->default(null);
            $table->datetime('arrived_at')->nullable()->default(null);
            $table->datetime('departed_at')->nullable()->default(null);
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
