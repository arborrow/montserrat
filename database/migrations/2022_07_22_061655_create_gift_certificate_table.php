<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_certificate', function (Blueprint $table) {
            $table->id();
            $table->integer('purchaser_id')->nullable()->index('idx_purchaser_id');
            $table->integer('recipient_id')->nullable()->index('idx_recipient_id');
            $table->dateTime('purchase_date')->nullable();
            $table->dateTime('issue_date')->nullable()->index('idx_issue_date');
            $table->dateTime('expiration_date')->nullable();
            $table->decimal('funded_amount', 13, 2)->nullable()->default('0.00');
            $table->integer('squarespace_order_number')->nullable()->index('idx_squarespace_order_number');
            $table->integer('sequential_number')->nullable()->index('idx_sequential_number');
            $table->string('retreat_type')->nullable();
            $table->text('notes', 65535)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gift_certificate');
    }
};
