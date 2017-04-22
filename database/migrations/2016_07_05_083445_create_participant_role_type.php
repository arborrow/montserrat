<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantRoleType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // modeled after CiviCRM option_group table
        // option_group_id default from CiviCROM option_group_table for participant_role
        Schema::create('participant_role_type', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('option_group_id')->unsigned()->default(13);
            $table->string('label');
            $table->text('value');
            $table->string('name')->nullable()->default(null);
            $table->string('grouping')->nullable()->default(null);
            $table->integer('filter')->unsigned()->nullable()->default(null);
            $table->boolean('is_default')->nullable()->default(0);
            $table->integer('weight')->unsigned();
            $table->text('description')->nullable()->default(null);
            $table->boolean('is_optgroup')->nullable()->default(0);
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(1);
            $table->integer('component_id')->unsigned()->nullable()->default(null);
            $table->integer('domain_id')->unsigned()->nullable()->default(null);
            $table->integer('visibility_id')->unsigned()->nullable()->default(null);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('participant_role_type');
    }
}
