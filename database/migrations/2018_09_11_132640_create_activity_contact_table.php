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
    public function up()
    {
        Schema::create('activity_contact', function (Blueprint $table) {
            $table->increments('id')->comment('Activity contact id');
            $table->integer('activity_id')->unsigned()->comment('Foreign key to the activity for this record.');
            $table->integer('contact_id')->unsigned()->comment('Foreign key to the contact for this record.');
            $table->integer('record_type_id')->unsigned()->nullable()->comment('Nature of this contact\'s role in the activity: 1 assignee, 2 creator, 3 focus or target.');
            $table->softDeletes();
            $table->timestamps();
            $table->text('remember_token', 65535)->nullable();
            $table->unique(['contact_id', 'activity_id', 'record_type_id'], 'UI_activity_contact');
            $table->index(['activity_id', 'record_type_id'], 'index_record_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_contact');
    }
};
