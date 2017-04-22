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
            $table->string('title')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->datetime('start_date')->nullable()->default(null);
            $table->datetime('end_date')->nullable()->default(null);
            $table->integer('campaign_type_id')->nullable()->unsigned()->default(null);
            $table->integer('status_id')->nullable()->unsigned()->default(null);
            $table->string('external_identifier')->nullable()->default(null);
            $table->integer('parent_id')->nullable()->unsigned()->default(null);
            $table->boolean('is_active')->nullable()->default(1);
            $table->integer('created_id')->unsigned()->nullable()->default(null);
            $table->datetime('created_date')->nullable()->default(null);
            $table->integer('last_modified_id')->unsigned()->nullable()->default(null);
            $table->datetime('last_modified_date')->nullable()->default(null);
            $table->text('goal_general')->nullable()->default(null);
            $table->decimal('goal_revenue', 20, 2)->nullable()->default(null);
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
