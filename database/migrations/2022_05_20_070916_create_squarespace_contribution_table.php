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
        Schema::create('squarespace_contribution', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id')->index('idx_message_id');
            $table->integer('contact_id')->nullable()->index('idx_contact_id');
            $table->integer('event_id')->nullable()->index('idx_event_id');
            $table->integer('donation_id')->nullable()->index('idx_donation_id');
            $table->integer('touchpoint_id')->nullable()->index('idx_touchpoint_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_supplemental')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_zip')->nullable();
            $table->string('address_country')->nullable();
            $table->string('phone')->nullable();
            $table->string('retreat_description')->nullable();
            $table->string('offering_type')->nullable();
            $table->decimal('amount', 13, 2)->default('0.00');
            $table->string('fund')->nullable();
            $table->string('idnumber')->nullable();
            $table->text('comments', 65535)->nullable();
            $table->boolean('is_processed')->nullable()->default(0);
            $table->string('stripe_charge_id')->index('idx_stripe_charge_id');
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
        Schema::dropIfExists('squarespace_contribution');
    }
};
