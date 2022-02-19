<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_processor_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->nullable()->index();
            $table->string('title', 127)->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->nullable();
            $table->boolean('is_default')->nullable();
            $table->string('user_name_label')->nullable();
            $table->string('password_label')->nullable();
            $table->string('signature_label')->nullable();
            $table->string('subject_label')->nullable();
            $table->string('class_name')->nullable();
            $table->string('url_site_default')->nullable();
            $table->string('url_api_default')->nullable();
            $table->string('url_recur_default')->nullable();
            $table->string('url_button_default')->nullable();
            $table->string('url_site_test_default')->nullable();
            $table->string('url_api_test_default')->nullable();
            $table->string('url_button_test_default')->nullable();
            $table->integer('billing_mode')->unsigned();
            $table->boolean('is_recur')->nullable();
            $table->integer('payment_type')->unsigned()->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_processor_type');
    }
};
