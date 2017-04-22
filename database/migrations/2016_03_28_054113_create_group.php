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
            $table->string('name')->nullable()->default(null);
            $table->string('title')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->string('source')->nullable()->default(null);
            $table->integer('saved_search_id')->nullable()->default(null);
            $table->boolean('is_active')->nullable()->default(null);
            $table->enum('visibility', ['User and User Admin Only','Public Pages'])->nullable()->default('User and User Admin Only');
            $table->text('where_clause')->nullable()->default(null);
            $table->text('select_tables')->nullable()->default(null);
            $table->text('where_tables')->nullable()->default(null);
            $table->string('group_type')->nullable()->default(null);
            $table->timestamp('cache_date')->nullable()->default(null);
            $table->timestamp('refresh_date')->nullable()->default(null);
            $table->text('parents')->nullable()->default(null);
            $table->text('children')->nullable()->default(null);
            $table->boolean('is_hidden')->nullable()->default(0);
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->integer('created_id')->nullable()->default(null);
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
