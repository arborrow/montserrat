<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_contact', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->integer('group_id');
            $table->integer('contact_id');
            $table->enum('status',['Added','Removed','Pending'])->nullable()->default(NULL);
            $table->integer('location_id')->nullable()->default(NULL);
            $table->integer('email_id')->nullable()->default(NULL);
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
         Schema::drop('group_contact');
    }
}
