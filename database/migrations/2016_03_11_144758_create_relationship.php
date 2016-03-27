<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relationship', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->integer('contact_id_a');
            $table->integer('contact_id_b');
            $table->integer('relationship_type_id');
            $table->date('start_date')->nullable()->default(NULL);
            $table->date('end_date')->nullable()->default(NULL);
            $table->boolean('is_active')->nullable()->default(NULL);
            $table->string('description')->nullable()->default(NULL);
            $table->boolean('is_permission_a_b')->nullable()->default(NULL);
            $table->boolean('is_permission_b_a')->nullable()->default(NULL);
            $table->integer('case_id');
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
        Schema::drop('relationship');
    }
}
