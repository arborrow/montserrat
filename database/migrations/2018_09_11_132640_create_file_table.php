<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('file_type_id')->nullable()->index('idx_file_type_id');
            $table->string('mime_type')->nullable();
            $table->string('uri')->nullable()->index('idx_uri');
            $table->binary('document', 16777215)->nullable();
            $table->string('description')->nullable()->index('idx_description');
            $table->dateTime('upload_date')->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->string('entity')->nullable();
            $table->integer('entity_id');
            $table->index(['entity', 'entity_id'], );
        });
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
