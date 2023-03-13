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
        Schema::create('gender', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->nullable();
            $table->string('value')->nullable();
            $table->string('name')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->boolean('is_default')->nullable()->default(0);
            $table->integer('weight')->nullable();
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
        Schema::dropIfExists('gender');
    }
};
