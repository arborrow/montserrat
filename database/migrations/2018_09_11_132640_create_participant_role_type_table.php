<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticipantRoleTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_role_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_group_id')->unsigned()->default(13);
            $table->string('label');
            $table->text('value', 65535);
            $table->string('name')->nullable();
            $table->string('grouping')->nullable();
            $table->integer('filter')->unsigned()->nullable();
            $table->boolean('is_default')->nullable()->default(0);
            $table->integer('weight')->unsigned();
            $table->text('description', 65535)->nullable();
            $table->boolean('is_optgroup')->nullable()->default(0);
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(1);
            $table->integer('component_id')->unsigned()->nullable();
            $table->integer('domain_id')->unsigned()->nullable();
            $table->integer('visibility_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
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
