<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('website', function (Blueprint $table) {
            $table->BigIncrements('id')->unsigned;
            $table->integer('contact_id')->nullable()->default(NULL);
            $table->string('url')->nullable()->default(NULL);
            $table->integer('website_type_id')->nullable()->default(NULL);
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
    
        Schema::drop('website');
    }
}
