<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCivicrmParticipantStatusTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('civicrm_participant_status_type', function (Blueprint $table) {
            $table->increments('id')->comment('unique participant status type id');
            $table->string('name', 64)->nullable()->comment('non-localized name of the status type');
            $table->string('label')->nullable()->comment('localized label for display of this status type');
            $table->string('class', 8)->nullable()->comment('the general group of status type this one belongs to');
            $table->boolean('is_reserved')->nullable()->comment('whether this is a status type required by the system');
            $table->boolean('is_active')->nullable()->default(1)->comment('whether this status type is active');
            $table->boolean('is_counted')->nullable()->comment('whether this status type is counted against event size limit');
            $table->integer('weight')->unsigned()->comment('controls sort order');
            $table->integer('visibility_id')->unsigned()->nullable()->comment('whether the status type is visible to the public, an implicit foreign key to option_value.value related to the `visibility` option_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('civicrm_participant_status_type');
    }
}
