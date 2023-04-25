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
        Schema::create('jesuits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id');
            $table->integer('community_id');
            $table->integer('province_id');
            $table->boolean('is_ordained')->nullable()->default(1);
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
        Schema::dropIfExists('jesuits');
    }
};
