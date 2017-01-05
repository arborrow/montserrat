<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mailgun_id')->unique();
            $table->timestamp('mailgun_timestamp');
            $table->string('storage_url')->nullable()->default(NULL);
            $table->string('from')->nullable()->default(NULL);
            $table->integer('from_id')->unsigned()->nullable()->default(NULL);
            $table->string('to')->nullable()->default(NULL);
            $table->integer('to_id')->unsigned()->nullable()->default(NULL);
            $table->string('subject')->nullable()->default(NULL);
            $table->text('body')->nullable()->default(NULL);
            $table->boolean('is_processed')->nullable()->default(0);
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::drop('messages');
    }
}
