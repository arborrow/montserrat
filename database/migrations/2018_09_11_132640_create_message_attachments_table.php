<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageAttachmentsTable extends Migration
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
            $table->integer('attachment_id')->unsigned()->nullable();
            $table->timestamp('mailgun_timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('url')->nullable();
            $table->string('content_type')->nullable();
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
        Schema::dropIfExists('message_attachments');
    }
}
