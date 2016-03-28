<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('name')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->string('source')->nullable()->default(NULL);
            $table->integer('saved_search_id')->nullable()->default(NULL);
            $table->boolean('is_active')->nullable()->default(NULL);
            $table->enum('visibility',['User and User Admin Only','Public Pages'])->nullable()->default('User and User Admin Only');
            $table->text('where_clause')->nullable()->default(NULL);
            $table->text('select_tables')->nullable()->default(NULL);
            $table->text('where_tables')->nullable()->default(NULL);
            $table->string('group_type')->nullable()->default(NULL);
            $table->timestamp('cache_date')->nullable()->default(NULL);
            $table->timestamp('refresh_date')->nullable()->default(NULL);
            $table->text('parents')->nullable()->default(NULL);
            $table->text('children')->nullable()->default(NULL);
            $table->boolean('is_hidden')->nullable()->default(0);
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->integer('created_id')->nullable()->default(NULL);
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
         Schema::drop('group');
    }
}
