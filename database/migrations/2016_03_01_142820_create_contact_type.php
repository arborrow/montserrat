<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('contact_type', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('name')->nullable()->default(null);
            $table->string('label')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->string('image_URL')->nullable()->default(null);
            $table->integer('parent_id')->nullable()->default(null);
            $table->Boolean('is_active')->nullable()->default(null);
            $table->Boolean('is_reserved')->nullable()->default(null);
            $table->string('status');
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
        //
        Schema::drop('contact_type');
    }
}
