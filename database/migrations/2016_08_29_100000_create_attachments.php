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
            $table->integer('file_type_id')->nullable()->default(null);
            $table->string('mime_type')->nullable()->default(null);
            $table->string('uri')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->dateTime('upload_date')->nullable()->default(null);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->string('entity')->nullable()->default(null);
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
