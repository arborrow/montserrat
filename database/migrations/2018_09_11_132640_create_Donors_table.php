<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Donors', function (Blueprint $table) {
            $table->integer('donor_id')->nullable()->unique('idx_donor_id');
            $table->string('FName', 80)->nullable();
            $table->string('MInitial', 50)->nullable();
            $table->string('LName', 100)->nullable();
            $table->string('Address', 100)->nullable();
            $table->string('Address2', 90)->nullable();
            $table->string('City', 90)->nullable();
            $table->string('State', 4)->nullable();
            $table->string('Zip', 22)->nullable();
            $table->string('NickName', 40)->nullable();
            $table->string('SpouseName', 60)->nullable();
            $table->string('HomePhone', 60)->nullable();
            $table->string('WorkPhone', 60)->nullable();
            $table->string('EMailAddress', 100)->nullable();
            $table->string('FaxNumber', 60)->nullable();
            $table->integer('worker_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('phase_id')->nullable();
            $table->integer('age_id')->nullable();
            $table->integer('occup_id')->nullable();
            $table->integer('church_id')->nullable();
            $table->integer('salut_id')->nullable();
            $table->string('NameEnd', 100)->nullable();
            $table->string('Gender', 2)->nullable();
            $table->integer('donation_type_id')->nullable();
            $table->integer('DonationID')->nullable();
            $table->integer('retreat_id')->nullable();
            $table->dateTime('retreat_date')->nullable();
            $table->char('First Visit', 1)->nullable();
            $table->char('Big Donor', 1)->nullable();
            $table->char('Old Donor', 1)->nullable();
            $table->integer('New Date ID')->nullable();
            $table->char('NotAvailable', 1)->nullable();
            $table->string('Note', 80)->nullable();
            $table->char('CampLetterSent', 1)->nullable();
            $table->dateTime('DateLetSent')->nullable();
            $table->char('AdventDonor', 1)->nullable();
            $table->char('Church', 1)->nullable();
            $table->char('Elderhostel', 1)->nullable();
            $table->char('Deceased', 1)->nullable();
            $table->char('Spouse', 1)->nullable();
            $table->string('RoomNum', 8)->nullable();
            $table->char('Cancel', 1)->nullable();
            $table->char('ReqRemoval', 1)->nullable();
            $table->string('Note1', 100)->nullable();
            $table->text('Note2', 65535)->nullable();
            $table->char('BoardMember', 1)->nullable();
            $table->char('NoticeSend', 1)->nullable();
            $table->char('Ambassador', 1)->nullable();
            $table->char('Knights', 1)->nullable();
            $table->string('AmbassadorSince', 40)->nullable();
            $table->char('ParkCityClub', 1)->nullable();
            $table->char('SpeedwayClub', 1)->nullable();
            $table->char('DonatedWillNotAttend', 1)->nullable();
            $table->char('PartyMailList', 1)->nullable();
            $table->char('SpiritDirect', 1)->nullable();
            $table->char('KofC Grand Councils', 1)->nullable();
            $table->char('Hispanic', 1)->nullable();
            $table->char('October Dinner Meeting', 1)->nullable();
            $table->char('Board Advisor', 1)->nullable();
            $table->string('cell_phone', 100)->nullable();
            $table->string('Emergency Contact Num', 100)->nullable();
            $table->string('Emergency Name', 100)->nullable();
            $table->string('Emergency Contact Num2', 100)->nullable();
            $table->char('St Rita Spiritual Exercises', 1)->nullable();
            $table->integer('contact_id')->nullable()->index();
            $table->string('sort_name')->nullable()->index('idx_sort_name');
            $table->integer('sort_name_count')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Donors');
    }
}
