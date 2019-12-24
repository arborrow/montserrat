<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpOfferingDedup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_offering_dedup', function (Blueprint $table) {
          $table->string('combo')->nullable()->default(NULL);
          $table->integer('contact_id')->nullable()->default(NULL);
          $table->integer('event_id')->nullable()->default(NULL);
          $table->integer('count')->default(0);
          $table->boolean('merged')->default(0);
          $table->softDeletes();
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
        Schema::dropIfExists('tmp_offering_dedup');
    }
}
