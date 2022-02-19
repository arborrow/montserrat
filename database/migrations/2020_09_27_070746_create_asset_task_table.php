<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_task', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asset_id')->required()->index('idxAssetId');
            $table->string('title')->required();
            $table->dateTime('start_date')->nullable();
            $table->string('frequency')->nullable();
            $table->integer('frequency_interval')->nullable();
            $table->integer('frequency_month')->nullable();
            $table->integer('frequency_day')->nullable();
            $table->time('frequency_time', 0)->nullable();
            $table->dateTime('scheduled_until_date')->nullable();
            $table->text('description')->nullable();
            $table->integer('priority_id')->nullable();
            $table->integer('needed_labor_minutes')->nullable();
            $table->decimal('estimated_labor_cost', 13, 2)->default('0.00')->nullable();
            $table->text('needed_material')->nullable();
            $table->decimal('estimated_material_cost', 13, 2)->default('0.00')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('category')->nullable();
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
        Schema::dropIfExists('asset_task');
    }
};
