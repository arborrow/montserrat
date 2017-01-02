<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentProcessor extends Migration
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
            $table->string('name',64)->nullable()->default(NULL);
            $table->string('description')->nullable()->default(NULL);
            $table->integer('payment_processor_type_id')->unsigned()->nullable()->default(NULL);
            $table->boolean('is_active')->nullable()->default(NULL);
            $table->boolean('is_default')->nullable()->default(NULL);
            $table->boolean('is_test')->nullable()->default(NULL);
            $table->string('user_name')->nullable()->default(NULL);
            $table->string('password')->nullable()->default(NULL);
            $table->string('signature')->nullable()->default(NULL);
            $table->string('url_site')->nullable()->default(NULL);
            $table->string('url_api')->nullable()->default(NULL);
            $table->string('url_recur')->nullable()->default(NULL);
            $table->string('url_button')->nullable()->default(NULL);
            $table->string('subject')->nullable()->default(NULL);
            $table->string('class_name')->nullable()->default(NULL);
            $table->integer('billing_mode')->unsigned();
            $table->boolean('is_recur')->nullable()->default(NULL);
            $table->integer('payment_type')->unsigned()->nullable()->default(1);
            $table->timestamps();
            
            $table->index(['name','is_test','domain_id'],'UI_name_test_domain_id');
            // $table->foreign('domain_id')->references('id')->on('domain');
            $table->foreign('payment_processor_type_id')->references('id')->on('payment_processor_type');
                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payment_processor');
    }
}
