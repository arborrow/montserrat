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
            $table->string('storage_url')->nullable()->default(null);
            $table->string('from')->nullable()->default(null);
            $table->integer('from_id')->unsigned()->nullable()->default(null);
            $table->string('to')->nullable()->default(null);
            $table->integer('to_id')->unsigned()->nullable()->default(null);
            $table->string('subject')->nullable()->default(null);
            $table->text('body')->nullable()->default(null);
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
