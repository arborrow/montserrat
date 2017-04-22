<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddcolumnsPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('phone', function ($table) {
            $table->enum('phone_type', ['Phone','Mobile','Fax','Pager','Voicemail','Other'])->nullable()->default(null);
            $table->enum('mobile_provider', ['Sprint','Verizon','Cingular','AT&T','T-Mobile','MetroPCS','US Cellular','Other'])->nullable()->default(null);
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
         Schema::table('phone', function ($table) {
            $table->dropColumn('phone_type');
            $table->dropColumn('mobile_provider');
         });
    }
}
