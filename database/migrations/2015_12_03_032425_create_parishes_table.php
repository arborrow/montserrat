<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('parishes', function (Blueprint $table) {
            $table->increments('id')->unsigned;
            $table->string('name');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('webpage');
            $table->integer('diocese_id');
            $table->string('pastor_id');
            $table->Text('notes');
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
        Schema::drop('parishes');
    }
}
