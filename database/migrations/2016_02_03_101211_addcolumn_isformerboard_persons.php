<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddcolumnIsformerboardPersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('persons', function ($table) {
            $table->Boolean('is_formerboard')->default('0')->nullable();
            $table->Boolean('is_jesuit')->default('0')->nullable();
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
        Schema::table('persons', function ($table) {
            $table->dropColumn('is_formerboard');
            $table->dropColumn('is_jesuit');
        });
    }
}
