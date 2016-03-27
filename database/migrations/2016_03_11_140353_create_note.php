<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('entity_table');
            $table->integer('entity_id');
            $table->text('note')->nullable()->default(NULL);
            $table->integer('contact_id')->nullable()->default(NULL);
            $table->timestamp('modified_date');
            $table->string('subject')->nullable()->default(NULL);
            $table->string('privacy')->nullable()->default(NULL);
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
        Schema::drop('note');
    }
}
