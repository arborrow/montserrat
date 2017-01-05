<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mailgun_id')->index();
            $table->integer('attachment_id')->unsigned()->nullable()->default(NULL);
            $table->timestamp('mailgun_timestamp');
            $table->string('url')->nullable()->default(NULL);
            $table->string('content_type')->nullable()->default(NULL);
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
        Schema::drop('message_attachments');
    }
}
