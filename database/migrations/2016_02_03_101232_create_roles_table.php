<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned;
            $table->string('name');
            $table->text('description');
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
             Schema::drop('roles');
}
}
