<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('file_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('value');
            $table->string('name')->nullable();
            $table->text('description', 65535)->nullable();
            $table->boolean('is_default')->nullable()->default(0);
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(1);
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
    public function down(): void
    {
        Schema::dropIfExists('file_type');
    }
};
