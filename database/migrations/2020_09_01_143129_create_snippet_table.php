<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('snippets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->required();
            $table->string('label')->required();
            $table->string('locale')->nullable()->default('en_US');
            $table->text('snippet', 65535)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snippets');
    }
};
