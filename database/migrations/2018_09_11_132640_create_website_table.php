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
        Schema::create('website', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('contact_id')->nullable()->index();
            $table->string('url')->nullable()->index('idx_url');
            $table->integer('website_type_id')->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->enum('website_type', ['Personal', 'Work', 'Main', 'Facebook', 'Google', 'Other', 'Instagram', 'LinkedIn', 'MySpace', 'Pinterest', 'SnapChat', 'Tumblr', 'Twitter', 'Vine'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website');
    }
};
