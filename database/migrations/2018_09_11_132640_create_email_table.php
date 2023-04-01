<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('contact_id')->nullable()->index();
            $table->integer('location_type_id')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_primary')->nullable()->default(0);
            $table->boolean('is_billing')->nullable()->default(0);
            $table->boolean('on_hold')->default(0);
            $table->boolean('is_bulkmail')->default(0);
            $table->date('hold_date')->nullable();
            $table->date('reset_date')->nullable();
            $table->text('signature_text', 65535)->nullable();
            $table->text('signature_html', 65535)->nullable();
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
        Schema::dropIfExists('email');
    }
};
