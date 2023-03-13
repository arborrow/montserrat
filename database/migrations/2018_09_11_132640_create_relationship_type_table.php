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
        Schema::create('relationship_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_a_b')->nullable();
            $table->string('name_b_a')->nullable();
            $table->string('label_a_b')->nullable();
            $table->string('label_b_a')->nullable();
            $table->text('description', 65535)->nullable();
            $table->enum('contact_type_a', ['Individual', 'Organization', 'Household'])->nullable();
            $table->enum('contact_type_b', ['Individual', 'Organization', 'Household'])->nullable();
            $table->string('contact_sub_type_a')->nullable();
            $table->string('contact_sub_type_b')->nullable();
            $table->boolean('is_reserved')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('occupancy');
            $table->string('status');
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
        Schema::dropIfExists('relationship_type');
    }
};
