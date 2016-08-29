<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->BigIncrements('id')->unsigned;
            $table->integer('file_type_id')->nullable()->default(NULL);
            $table->string('mime_type')->nullable()->default(NULL);
            $table->string('uri')->nullable()->default(NULL);
            $table->string('description')->nullable()->default(NULL);
            $table->dateTime('upload_date')->nullable()->default(NULL);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->string('entity')->nullable()->default(NULL);
            $table->integer('entity_id')->unsigned;
        });
        DB::statement("ALTER TABLE file ADD document MEDIUMBLOB AFTER uri");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('file');
    }
}
