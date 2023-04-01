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
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mailgun_id')->unique();
            $table->timestamp('mailgun_timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('storage_url')->nullable();
            $table->string('recipients')->nullable();
            $table->string('from')->nullable();
            $table->integer('from_id')->unsigned()->nullable();
            $table->string('to')->nullable();
            $table->integer('to_id')->unsigned()->nullable();
            $table->string('subject')->nullable();
            $table->text('body', 65535)->nullable();
            $table->boolean('is_processed')->nullable()->default(0);
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
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
