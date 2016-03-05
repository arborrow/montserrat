<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddcolumnsWebsite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('website', function ($table) {
           $table->enum('website_type',['Personal','Work','Main','Facebook','Google','Other','Instagram','LinkedIn','MySpace','Pinterest','SnapChat','Tumblr','Twitter','Vine'])->nullable()->default(NULL);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phone', function ($table) {
            $table->dropColumn('website_type');
        });
    }
}
