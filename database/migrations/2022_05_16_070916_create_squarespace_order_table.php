<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('squarespace_order', function (Blueprint $table) {
            $table->id();
            $table->integer('order_number')->nullable();
            $table->string('retreat_category')->nullable();
            $table->string('retreat_sku')->nullable();
            $table->string('retreat_description')->nullable();
            $table->string('retreat_dates')->nullable();
            $table->string('retreat_start_date')->nullable();
            $table->string('retreat_idnumber')->nullable();
            $table->string('retreat_registration_type')->nullable();
            $table->string('retreat_couple')->nullable();
            $table->integer('retreat_quantity')->nullable();
            $table->decimal('deposit_amount', 13, 2)->default('0.00');
            $table->decimal('unit_price', 13, 2)->default('0.00');
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('full_address')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_supplemental')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_zip')->nullable();
            $table->string('address_country')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('dietary')->nullable();
            $table->string('room_preference')->nullable();
            $table->string('preferred_language')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('parish')->nullable();
            $table->text('comments', 65535)->nullable();
            $table->date('couple_date_of_birth')->nullable();
            $table->string('couple_dietary')->nullable();
            $table->string('couple_email')->nullable();
            $table->string('couple_emergency_contact')->nullable();
            $table->string('couple_emergency_contact_relationship')->nullable();
            $table->string('couple_emergency_contact_phone')->nullable();
            $table->string('couple_title')->nullable();
            $table->string('couple_name')->nullable();
            $table->string('couple_mobile_phone')->nullable();
            $table->string('gift_certificate_number')->nullable();
            $table->integer('gift_certificate_year_issued')->nullable();
            $table->text('additional_names_and_phone_numbers', 65535)->nullable();
            $table->integer('message_id')->index('idx_message_id');
            $table->integer('event_id')->nullable()->index('idx_event_id');
            $table->integer('contact_id')->nullable()->index('idx_contact_id');
            $table->integer('couple_contact_id')->nullable()->index('idx_couple_contact_id');
            $table->integer('participant_id')->nullable()->index('idx_participant_id');
            $table->integer('touchpoint_id')->nullable()->index('idx_touchpoint_id');
            $table->integer('donation_id')->nullable()->index('idx_donation_id');
            $table->integer('couple_donation_id')->nullable()->index('idx_couple_donation_id');
            $table->string('stripe_charge_id')->nullable()->index('idx_stripe_charge_id');
            $table->text('email_body', 65535)->nullable();
            $table->boolean('is_processed')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('squarespace_order');
    }
};
