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
        Schema::create('participant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned()->index('idx_contact');
            $table->integer('event_id')->unsigned()->index('idx_event');
            $table->integer('status_id')->unsigned()->default(1);
            $table->integer('role_id')->unsigned()->nullable()->default(5);
            $table->dateTime('register_date')->nullable();
            $table->string('source')->nullable();
            $table->text('fee_level', 65535)->nullable();
            $table->boolean('is_test')->nullable()->default(0);
            $table->boolean('is_pay_later')->nullable()->default(0);
            $table->decimal('fee_amount', 20)->nullable();
            $table->integer('registered_by_id')->unsigned()->nullable();
            $table->integer('discount_id')->unsigned()->nullable();
            $table->string('fee_currency', 3)->nullable();
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->integer('discount_amount')->unsigned()->nullable();
            $table->integer('cart_id')->unsigned()->nullable();
            $table->integer('must_wait')->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->dateTime('registration_confirm_date')->nullable();
            $table->dateTime('attendance_confirm_date')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->text('notes', 65535)->nullable();
            $table->decimal('deposit', 13, 2)->default(0.00);
            $table->dateTime('canceled_at')->nullable();
            $table->dateTime('arrived_at')->nullable();
            $table->dateTime('departed_at')->nullable();
            $table->integer('room_id')->unsigned()->nullable();
            $table->integer('donation_id')->nullable()->unique();
            $table->string('ppd_source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant');
    }
};
