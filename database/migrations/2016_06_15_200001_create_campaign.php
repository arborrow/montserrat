<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('title')->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->datetime('start_date')->nullable()->default(NULL);
            $table->datetime('end_date')->nullable()->default(NULL);
            $table->integer('campaign_type_id')->nullable()->unsigned()->default(NULL);
            $table->integer('status_id')->nullable()->unsigned()->default(NULL);
            $table->string('external_identifier')->nullable()->default(NULL);
            $table->integer('parent_id')->nullable()->unsigned()->default(NULL);
            $table->boolean('is_active')->nullable()->default(1);
            $table->integer('created_id')->unsigned()->nullable()->default(NULL);
            $table->datetime('created_date')->nullable()->default(NULL);
            $table->integer('last_modified_id')->unsigned()->nullable()->default(NULL);
            $table->datetime('last_modified_date')->nullable()->default(NULL);
            $table->text('goal_general')->nullable()->default(NULL);
            $table->decimal('goal_revenue',20,2)->nullable()->default(NULL);
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
        Schema::drop('campaign');
    }
}
