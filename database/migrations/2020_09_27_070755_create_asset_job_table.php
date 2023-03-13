<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->text('additional_materials')->nullable();
            $table->integer('actual_labor')->nullable();
            $table->decimal('actual_labor_cost', 13, 2)->default('0.00')->nullable();
            $table->decimal('actual_material_cost', 13, 2)->default('0.00')->nullable();
            $table->text('note')->nullable();
            $table->string('tag')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
};
