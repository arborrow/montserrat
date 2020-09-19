<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->text('description', 65535)->nullable();
            $table->text('remarks', 65535)->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->integer('year')->nullable();
            $table->string('status')->nullable(); //TODO: evaluate making possible enum or coming up with a status_id list

            $table->integer('asset_type_id')->required();
            $table->integer('location_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('replacement_id')->nullable();
            $table->integer('manufacturer_id')->nullable();
            $table->integer('vendor_id')->nullable();

            // Electrial fields
            // TODO: add uom table to polanco to facilitate setting a default value that is not hard coded

            $table->integer('power_line_voltage')->nullable();
            $table->integer('power_line_voltage_uom_id')->nullable();
            $table->integer('power_phase_voltage')->nullable();
            $table->integer('power_phase_voltage_uom_id')->nullable();
            $table->integer('power_phases')->nullable();
            $table->decimal('power_amp', 8, 2)->nullable();
            $table->integer('power_amp_uom_id')->nullable();

            // Physical dimensions
            $table->decimal('length', 8, 2)->nullable();
            $table->integer('length_uom_id')->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->integer('width_uom_id')->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->integer('height_uom_id')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->integer('weight_uom_id')->nullable();
            $table->decimal('capacity', 8, 2)->nullable();
            $table->integer('capacity_uom_id')->nullable();

            // Dates
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->decimal('purchase_price', 13, 2)->default('0.00')->nullable();
            $table->dateTime('warranty_start_date')->nullable();
            $table->dateTime('warranty_end_date')->nullable();
            $table->dateTime('depreciation_start_date')->nullable();
            $table->dateTime('depreciation_end_date')->nullable();
            $table->integer('depreciation_type_id')->nullable();
            $table->integer('depreciation_time')->nullable();
            $table->integer('depreciation_time_uom_id')->nullable(); //typcially months
            $table->decimal('depreciation_rate', 13, 2)->default('0.00')->nullable();
            $table->decimal('depreciation_value', 13, 2)->default('0.00')->nullable();
            $table->decimal('life_expectancy', 8, 2)->nullable();
            $table->integer('life_expectancy_uom_id')->nullable();

            $table->boolean('is_active')->nullable()->default(1);
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
        Schema::dropIfExists('asset');
    }
}
