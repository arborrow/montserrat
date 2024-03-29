<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participant_status_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('label')->nullable();
            $table->text('value', 65535)->nullable();
            $table->enum('class', ['Positive', 'Pending', 'Waiting', 'Negative'])->nullable();
            $table->boolean('is_reserved')->nullable();
            $table->boolean('is_active')->nullable()->default(1);
            $table->boolean('is_counted')->nullable();
            $table->integer('weight')->unsigned();
            $table->integer('visibility_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_status_type');
    }
};
