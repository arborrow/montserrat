<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationshipType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('relationship_type', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('name_a_b')->nullable()->default(NULL);
            $table->string('name_b_a')->nullable()->default(NULL);
            $table->string('label_a_b')->nullable()->default(NULL);
            $table->string('label_b_a')->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->enum('contact_type_a',['Individual','Organization','Household'])->nullable()->default(NULL);
            $table->enum('contact_type_b',['Individual','Organization','Household'])->nullable()->default(NULL);
            $table->string('contact_sub_type_a')->nullable()->default(NULL);
            $table->string('contact_sub_type_b')->nullable()->default(NULL);
            $table->Boolean('is_reserved')->nullable()->default(NULL);
            $table->Boolean('is_active')->default('1');
            $table->string('occupancy');
            $table->string('status');
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
        Schema::drop('relationship_type');
    }
}
