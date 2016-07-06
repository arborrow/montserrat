<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantStatusType extends Migration
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
        Schema::create('participant_status_type', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable()->default(NULL);
            $table->string('label')->nullable()->default(NULL);
            $table->text('value')->nullable()->default(NULL);
            $table->enum('class',['Positive','Pending','Waiting','Negative'])->nullable()->default(NULL);
            $table->boolean('is_reserved')->nullable()->default(NULL);
            $table->boolean('is_active')->nullable()->default(1);
            $table->boolean('is_counted')->nullable()->default(NULL);
            $table->integer('weight')->unsigned();
            $table->integer('visibility_id')->unsigned()->nullable()->default(NULL);
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
        Schema::drop('participant_status_type');
    }
}