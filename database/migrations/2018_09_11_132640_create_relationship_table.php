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
        Schema::create('relationship', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id_a')->index('idx_contact_a');
            $table->integer('contact_id_b')->index('idx_contact_b');
            $table->integer('relationship_type_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_permission_a_b')->nullable();
            $table->boolean('is_permission_b_a')->nullable();
            $table->integer('case_id')->default(0);
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
        Schema::dropIfExists('relationship');
    }
};
