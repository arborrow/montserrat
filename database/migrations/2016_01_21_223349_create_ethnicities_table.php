<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEthnicitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
            Schema::create('ethnicities', function (Blueprint $table) {
                $table->increments('id')->unsigned;
                $table->string('ethnicity');
                $table->Text('description');
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
           Schema::drop('ethnicities');
    }
}
