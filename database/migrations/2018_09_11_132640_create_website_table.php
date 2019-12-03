<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWebsiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('contact_id')->nullable()->index('idx_contact_id');
            $table->string('url')->nullable()->index('idx_url');
            $table->integer('website_type_id')->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->enum('website_type', ['Personal', 'Work', 'Main', 'Facebook', 'Google', 'Other', 'Instagram', 'LinkedIn', 'MySpace', 'Pinterest', 'SnapChat', 'Tumblr', 'Twitter', 'Vine'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('website');
    }
}
