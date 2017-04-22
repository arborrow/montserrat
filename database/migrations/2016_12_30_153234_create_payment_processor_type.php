<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentProcessorType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_processor_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->nullable()->default(null)->index('UI_name');
            $table->string('title', 127)->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->boolean('is_active')->nullable()->default(null);
            $table->boolean('is_default')->nullable()->default(null);
            $table->string('user_name_label')->nullable()->default(null);
            $table->string('password_label')->nullable()->default(null);
            $table->string('signature_label')->nullable()->default(null);
            $table->string('subject_label')->nullable()->default(null);
            $table->string('class_name')->nullable()->default(null);
            $table->string('url_site_default')->nullable()->default(null);
            $table->string('url_api_default')->nullable()->default(null);
            $table->string('url_recur_default')->nullable()->default(null);
            $table->string('url_button_default')->nullable()->default(null);
            $table->string('url_site_test_default')->nullable()->default(null);
            $table->string('url_api_test_default')->nullable()->default(null);
            $table->string('url_button_test_default')->nullable()->default(null);
            $table->integer('billing_mode')->unsigned();
            $table->boolean('is_recur')->nullable()->default(null);
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
        Schema::drop('payment_processor_type');
    }
}
