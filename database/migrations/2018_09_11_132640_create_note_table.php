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
        Schema::create('note', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entity_table');
            $table->integer('entity_id');
            $table->text('note', 65535)->nullable();
            $table->integer('contact_id')->nullable();
            $table->timestamp('modified_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('subject')->nullable()->index('idx_subject');
            $table->string('privacy')->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->index(['entity_table', 'entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('note');
    }
};
