<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Because asset_type.label will be used in drop down boxes they should be unique unless they have been deleted.
     */
    public function up(): void
    {
        Schema::create('uom', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['Data', 'Time', 'Electric current', 'Length', 'Area', 'Volume', 'Mass', 'Temperature', 'Luminosity']);
            $table->string('unit_name')->nullable();
            $table->string('unit_symbol')->nullable();
            $table->text('description', 65535)->nullable();
            $table->boolean('is_active')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uom');
    }
};
