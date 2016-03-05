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
            $table->string('name')->nullable()->default(NULL);
            $table->string('display_name')->nullable()->default(NULL);
            $table->string('vcard_name')->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->Boolean('is_reserved')->nullable()->default(NULL);
            $table->Boolean('is_active')->nullable()->default(NULL);
            $table->Boolean('is_default')->nullable()->default(NULL);
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
