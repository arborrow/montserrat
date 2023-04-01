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
        Schema::create('phone', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('contact_id')->nullable()->index();
            $table->integer('location_type_id')->nullable();
            $table->integer('is_primary')->default(0);
            $table->integer('is_billing')->default(0);
            $table->integer('mobile_provider_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_ext')->nullable();
            $table->string('phone_numeric')->nullable();
            $table->integer('phone_type_id')->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->enum('phone_type', ['Phone', 'Mobile', 'Fax', 'Pager', 'Voicemail', 'Other'])->nullable();
            $table->enum('mobile_provider', ['Sprint', 'Verizon', 'Cingular', 'AT&T', 'T-Mobile', 'MetroPCS', 'US Cellular', 'Other'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('phone');
    }
};
