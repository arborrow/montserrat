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
        Schema::create('asset_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->index('idx_label')->comment('Asset type labels are unique');
            $table->string('name')->nullable();
            $table->text('description', 65535)->nullable();
            $table->boolean('is_active')->nullable()->default(1);
            $table->integer('parent_asset_type_id')->unsigned()->nullable()->comment('Self referential foreign key to the parent asset type.');
            $table->timestamps();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->unique(['label', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_type');
    }
};
