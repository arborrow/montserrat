<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        Schema::create('email', function (Blueprint $table) {
            $table->BigIncrements('id')->unsigned;
            $table->Integer('contact_id')->unsigned->nullable()->default(null);
            $table->Integer('location_type_id')->unsigned->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->Boolean('is_primary')->nullable()->default(0);
            $table->Boolean('is_billing')->nullable()->default(0);
            $table->Boolean('on_hold')->default(0);
            $table->Boolean('is_bulkmail')->default(0);
            $table->date('hold_date')->nullable();
            $table->date('reset_date')->nullable();
            $table->text('signature_text')->nullable()->default(null);
            $table->text('signature_html')->nullable()->default(null);
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
        Schema::drop('email');
    }
}
