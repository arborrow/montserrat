<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddcolumnsCategoriesTouchpoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('touchpoints', function ($table) {
            $table->integer('touchcategory_id')->unsigned()->nullable()->default(null);
            $table->string('status')->default('Resolved');
            $table->string('urgency')->default('Normal');
            $table->Timestamp('due_at')->nullable()->default(null);
            $table->integer('assignedto_id')->unsigned()->nullable()->default(null);
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
    
        Schema::table('touchpoints', function ($table) {
            $table->dropColumn('touchcategory_id');
            $table->dropColumn('status');
            $table->dropColumn('urgency');
            $table->dropColumn('due_at');
            $table->dropColumn('assignedto_id');
        });
    }
}
