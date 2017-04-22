<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('location_type', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('name')->nullable()->default(null);
            $table->string('display_name')->nullable()->default(null);
            $table->string('vcard_name')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->Boolean('is_reserved')->nullable()->default(null);
            $table->Boolean('is_active')->nullable()->default(null);
            $table->Boolean('is_default')->nullable()->default(null);
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
        Schema::drop('location_type');
    }
}
