<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJesuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('jesuits', function (Blueprint $table) {
            $table->increments('id')->unsigned;
            $table->Integer('person_id');
            $table->Integer('community_id');
            $table->Integer('province_id');
            $table->Boolean('is_ordained')->nullable()->default('1');
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
             Schema::drop('jesuits');
    }
}
