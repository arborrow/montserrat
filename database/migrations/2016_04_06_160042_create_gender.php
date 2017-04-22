<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('gender', function (Blueprint $table) {
            $table->increments('id')->unsigned;
            $table->string('label')->nullable()->default(null);
            $table->string('value')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->boolean('is_active')->nullable()->default(0);
            $table->boolean('is_default')->nullable()->default(0);
            $table->integer('weight')->nullable()->default(null)->unsigned;
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
        Schema::drop('gender');
    }
}
