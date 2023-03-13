<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id')->comment('Unique  Other Activity ID');
            $table->integer('source_record_id')->unsigned()->nullable()->index('UI_source_record_id')->comment('Artificial FK to original transaction (e.g. contribution) IF it is not an Activity. Table can be figured out through activity_type_id, and further through component registry.');
            $table->integer('activity_type_id')->unsigned()->default(1)->index('UI_activity_type_id')->comment('FK to civicrm_option_value.id, that has to be valid, registered activity type.');
            $table->string('subject')->nullable()->comment('The subject/purpose/short description of the activity.');
            $table->dateTime('activity_date_time')->nullable()->index('index_activity_date_time')->comment('Date and time this activity is scheduled to occur. Formerly named scheduled_date_time.');
            $table->integer('duration')->unsigned()->nullable()->comment('Planned or actual duration of activity expressed in minutes. Conglomerate of former duration_hours and duration_minutes.');
            $table->string('location')->nullable()->comment('Location of the activity (optional, open text).');
            $table->integer('phone_id')->unsigned()->nullable()->index('FK_civicrm_activity_phone_id')->comment('Phone ID of the number called (optional - used if an existing phone number is selected).');
            $table->string('phone_number', 64)->nullable()->comment('Phone number in case the number does not exist in the civicrm_phone table.');
            $table->text('details')->nullable()->comment('Details about the activity (agenda, notes, etc).');
            $table->integer('status_id')->unsigned()->nullable()->index('index_status_id')->comment('ID of the status this activity is currently in. Foreign key to civicrm_option_value.');
            $table->integer('priority_id')->unsigned()->nullable()->comment('ID of the priority given to this activity. Foreign key to civicrm_option_value.');
            $table->integer('parent_id')->unsigned()->nullable()->index('FK_civicrm_activity_parent_id')->comment('Parent meeting ID (if this is a follow-up item). This is not currently implemented');
            $table->boolean('is_test')->nullable()->default(0);
            $table->integer('medium_id')->unsigned()->nullable()->index('index_medium_id')->comment('Activity Medium, Implicit FK to civicrm_option_value where option_group = encounter_medium.');
            $table->boolean('is_auto')->nullable()->default(0);
            $table->integer('relationship_id')->unsigned()->nullable()->index('FK_civicrm_activity_relationship_id')->comment('FK to Relationship ID');
            $table->boolean('is_current_revision')->nullable()->default(1)->index('index_is_current_revision');
            $table->integer('original_id')->unsigned()->nullable()->index('FK_civicrm_activity_original_id')->comment('Activity ID of the first activity record in versioning chain.');
            $table->string('result')->nullable()->comment('Currently being used to store result id for survey activity, FK to option value.');
            $table->boolean('is_deleted')->nullable()->default(0)->index('index_is_deleted');
            $table->integer('campaign_id')->unsigned()->nullable()->index('FK_civicrm_activity_campaign_id')->comment('The campaign for which this activity has been triggered.');
            $table->integer('engagement_level')->unsigned()->nullable()->comment('Assign a specific level of engagement to this activity. Used for tracking constituents in ladder of engagement.');
            $table->integer('weight')->nullable();
            $table->boolean('is_star')->nullable()->default(0)->comment('Activity marked as favorite.');
            $table->softDeletes();
            $table->timestamps();
            $table->text('remember_token', 65535)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity');
    }
};
