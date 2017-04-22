<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::create('registrations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned;
            $table->integer('retreatant_id')->unsigned();
            $table->integer('retreat_id')->unsigned();
            $table->timestamp('start');
            $table->timestamp('end');
            $table->timestamp('register');
            $table->timestamp('confirmregister');
            $table->timestamp('confirmattend');
            $table->string('confirmedby')->nullable();
            $table->text('notes');
            $table->decimal('deposit', 7, 2);
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
          Schema::drop('registrations');
    }
}
