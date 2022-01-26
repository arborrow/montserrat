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
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('summary', 65535)->nullable();
            $table->text('description', 65535)->nullable();
            $table->integer('event_type_id')->unsigned()->nullable()->default(0);
            $table->integer('participant_listing_id')->unsigned()->nullable()->default(0);
            $table->boolean('is_public')->nullable()->default(1);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('is_online_registration')->nullable()->default(0);
            $table->string('registration_link_text')->nullable();
            $table->dateTime('registration_start_date')->nullable();
            $table->dateTime('registration-end_date')->nullable();
            $table->integer('max_participants')->unsigned()->nullable();
            $table->text('event_full_text', 65535)->nullable();
            $table->boolean('is_monetary')->nullable()->default(0);
            $table->integer('financial_type_id')->unsigned()->nullable();
            $table->string('payment_processor')->nullable();
            $table->boolean('is_map')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->string('fee_label')->nullable();
            $table->boolean('is_show_location')->nullable()->default(1);
            $table->integer('loc_block_id')->unsigned()->nullable();
            $table->integer('default_role_id')->unsigned()->nullable()->default(1);
            $table->text('intro_text', 65535)->nullable();
            $table->text('footer_text', 65535)->nullable();
            $table->string('confirm_title')->nullable();
            $table->text('confirm_text', 65535)->nullable();
            $table->text('confirm_footer_text', 65535)->nullable();
            $table->boolean('is_email_confirm')->nullable()->default(0);
            $table->text('confirm_email_text', 65535)->nullable();
            $table->string('confirm_from_name')->nullable();
            $table->string('confirm_from_email')->nullable();
            $table->string('cc_confirm')->nullable();
            $table->string('bc_confirm')->nullable();
            $table->integer('default_fee_id')->unsigned()->nullable();
            $table->integer('default_discount_fee_id')->unsigned()->nullable();
            $table->string('thankyou_title')->nullable();
            $table->text('thankyou_text', 65535)->nullable();
            $table->text('thankyou_footer_text', 65535)->nullable();
            $table->boolean('is_pay_later')->nullable()->default(0);
            $table->text('pay_later_text', 65535)->nullable();
            $table->text('pay_later_receipt', 65535)->nullable();
            $table->boolean('is_partial_payment')->nullable()->default(0);
            $table->string('initial_amount_label')->nullable();
            $table->text('initial_amount_help_text', 65535)->nullable();
            $table->decimal('min_initial_amount', 20)->nullable();
            $table->boolean('is_multiple_registrations')->nullable()->default(0);
            $table->boolean('allow_same_participant_emails')->nullable()->default(0);
            $table->boolean('has_waitlist')->nullable();
            $table->boolean('requires_approval')->nullable();
            $table->integer('expiration_time')->unsigned()->nullable();
            $table->text('waitlist_text', 65535)->nullable();
            $table->text('approval_req_text', 65535)->nullable();
            $table->boolean('is_template')->nullable()->default(0);
            $table->string('template_title')->nullable();
            $table->integer('created_id')->unsigned()->nullable();
            $table->dateTime('created_date')->nullable();
            $table->string('currency', 3)->nullable();
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->boolean('is_share')->nullable()->default(1);
            $table->integer('parent_event_id')->unsigned()->nullable();
            $table->integer('slot_label_id')->unsigned()->nullable();
            $table->integer('retreat_id')->unsigned()->nullable();
            $table->string('idnumber')->nullable()->comment('idnumber');
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->integer('ppd_id')->nullable()->unique();
            $table->string('calendar_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event');
    }
};
