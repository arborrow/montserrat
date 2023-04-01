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
        Schema::create('group_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('contact_id');
            $table->enum('status', ['Added', 'Removed', 'Pending'])->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('email_id')->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->unique(['group_id', 'contact_id'], 'idx_group_contact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('group_contact');
    }
};
