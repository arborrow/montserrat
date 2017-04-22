<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReligion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('religion', function (Blueprint $table) {
            $table->increments('id')->unsigned;
            $table->string('label');
            $table->string('value');
            $table->string('name');
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
        Schema::drop('religion');
    }
}
