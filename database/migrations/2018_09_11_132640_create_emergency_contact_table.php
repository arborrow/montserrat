<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unique();
            $table->string('name')->nullable()->index('idx_name');
            $table->string('relationship')->nullable()->index('idx_relationship');
            $table->string('phone')->nullable()->index('idx_phone');
            $table->string('phone_alternate')->nullable()->index('idx_phone_alternate');
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
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
        Schema::dropIfExists('emergency_contact');
    }
};
