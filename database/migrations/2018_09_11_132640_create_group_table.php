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
        Schema::create('group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->text('description', 65535)->nullable();
            $table->string('source')->nullable();
            $table->integer('saved_search_id')->nullable();
            $table->boolean('is_active')->nullable();
            $table->enum('visibility', ['User and User Admin Only', 'Public Pages'])->nullable()->default('User and User Admin Only');
            $table->text('where_clause', 65535)->nullable();
            $table->text('select_tables', 65535)->nullable();
            $table->text('where_tables', 65535)->nullable();
            $table->string('group_type')->nullable();
            $table->dateTime('cache_date')->nullable();
            $table->dateTime('refresh_date')->nullable();
            $table->text('parents', 65535)->nullable();
            $table->text('children', 65535)->nullable();
            $table->boolean('is_hidden')->nullable()->default(0);
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->integer('created_id')->nullable();
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
        Schema::dropIfExists('group');
    }
};
