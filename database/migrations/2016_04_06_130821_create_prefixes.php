<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrefixes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('prefix', function (Blueprint $table) {
                $table->Increments('id')->unsigned;
                $table->string('name')->nullable()->default(null);
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
        Schema::drop('prefix');
    }
}
