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
    public function up()
    {
        Schema::create('payment_processor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('domain_id')->unsigned();
            $table->string('name', 64)->nullable();
            $table->string('description')->nullable();
            $table->integer('payment_processor_type_id')->unsigned()->nullable()->index('payment_processor_payment_processor_type_id_foreign');
            $table->boolean('is_active')->nullable();
            $table->boolean('is_default')->nullable();
            $table->boolean('is_test')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->string('signature')->nullable();
            $table->string('url_site')->nullable();
            $table->string('url_api')->nullable();
            $table->string('url_recur')->nullable();
            $table->string('url_button')->nullable();
            $table->string('subject')->nullable();
            $table->string('class_name')->nullable();
            $table->integer('billing_mode')->unsigned();
            $table->boolean('is_recur')->nullable();
            $table->integer('payment_type')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->index(['name', 'is_test', 'domain_id'], 'UI_name_test_domain_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_processor');
    }
};
