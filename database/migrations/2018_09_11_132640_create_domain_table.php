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
        Schema::create('domain', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->nullable()->index();
            $table->string('description')->nullable();
            $table->text('config_backend', 65535)->nullable();
            $table->string('version', 32)->nullable();
            $table->integer('contact_id')->unsigned()->nullable()->index('domain_contact_id_foreign');
            $table->text('locales', 65535)->nullable();
            $table->text('locale_custom_strings', 65535)->nullable();
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
        Schema::dropIfExists('domain');
    }
};
