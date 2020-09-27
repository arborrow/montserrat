<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_job', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_task_id')->required()->index('idxAssetTaskId');
            $table->integer('assigned_to_id')->nullable()->index('idxAssignedToId');
            $table->dateTime('scheduled_date')->required()->index('idxScheduledDate');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('status')->required();
            $table->text('needed_materials')->nullable();
            $table->integer('needed_labor')->nullable();
            $table->decimal('estimated_labor_cost', 13, 2)->default('0.00')->nullable();
            $table->decimal('estimated_material_cost', 13, 2)->default('0.00')->nullable();
            $table->text('note')->nullable();
            $table->string('tag')->nullable();
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
        Schema::dropIfExists('asset_job');
    }
}
