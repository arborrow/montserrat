<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title')->nullable()->default(null);
            $table->text('summary')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->integer('event_type_id')->unsigned()->nullable()->default(0);
            $table->integer('participant_listing_id')->nullable()->unsigned()->default(0);
            $table->boolean('is_public')->nullable()->default(1);
            $table->datetime('start_date')->nullable()->default(null);
            $table->datetime('end_date')->nullable()->default(null);
            $table->boolean('is_online_registration')->nullable()->default(0);
            $table->string('registration_link_text')->nullable()->default(null);
            $table->datetime('registration_start_date')->nullable()->default(null);
            $table->datetime('registration-end_date')->nullable()->default(null);
            $table->integer('max_participants')->unsigned()->nullable()->default(null);
            $table->text('event_full_text')->nullable()->default(null);
            $table->boolean('is_monetary')->nullable()->default(0);
            $table->integer('financial_type_id')->unsigned()->nullable()->default(null);
            $table->string('payment_processor')->nullable()->default(null);
            $table->boolean('is_map')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->string('fee_label')->nullable()->default(null);
            $table->boolean('is_show_location')->nullable()->default(1);
            $table->integer('loc_block_id')->unsigned()->nullable()->default(null);
            $table->integer('default_role_id')->unsigned()->nullable()->default(1);
            $table->text('intro_text')->nullable()->default(null);
            $table->text('footer_text')->nullable()->default(null);
            $table->string('confirm_title')->nullable()->default(null);
            $table->text('confirm_text')->nullable()->default(null);
            $table->text('confirm_footer_text')->nullable()->default(null);
            $table->boolean('is_email_confirm')->nullable()->default(0);
            $table->text('confirm_email_text')->nullable()->default(null);
            $table->string('confirm_from_name')->nullable()->default(null);
            $table->string('confirm_from_email')->nullable()->default(null);
            $table->string('cc_confirm')->nullable()->default(null);
            $table->string('bc_confirm')->nullable()->default(null);
            $table->integer('default_fee_id')->unsigned()->nullable()->default(null);
            $table->integer('default_discount_fee_id')->unsigned()->nullable()->default(null);
            $table->string('thankyou_title')->nullable()->default(null);
            $table->text('thankyou_text')->nullable()->default(null);
            $table->text('thankyou_footer_text')->nullable()->default(null);
            $table->boolean('is_pay_later')->nullable()->default(0);
            $table->text('pay_later_text')->nullable()->default(null);
            $table->text('pay_later_receipt')->nullable()->default(null);
            $table->boolean('is_partial_payment')->nullable()->default(0);
            $table->string('initial_amount_label')->nullable()->default(null);
            $table->text('initial_amount_help_text')->nullable()->default(null);
            $table->decimal('min_initial_amount', 20, 2)->nullable()->default(null);
            $table->boolean('is_multiple_registrations')->nullable()->default(0);
            $table->boolean('allow_same_participant_emails')->nullable()->default(0);
            $table->boolean('has_waitlist')->nullable()->default(null);
            $table->boolean('requires_approval')->nullable()->default(null);
            $table->integer('expiration_time')->unsigned()->nullable()->default(null);
            $table->text('waitlist_text')->nullable()->default(null);
            $table->text('approval_req_text')->nullable()->default(null);
            $table->boolean('is_template')->nullable()->default(0);
            $table->string('template_title')->nullable()->default(null);
            $table->integer('created_id')->unsigned()->nullable()->default(null);
            $table->datetime('created_date')->nullable()->default(null);
            $table->string('currency', 3)->nullable()->default(null);
            $table->integer('campaign_id')->unsigned()->nullable()->default(null);
            $table->boolean('is_share')->nullable()->default(1);
            $table->integer('parent_event_id')->unsigned()->nullable()->default(null);
            $table->integer('slot_label_id')->unsigned()->nullable()->default(null);
            $table->integer('retreat_id')->unsigned()->nullable()->default(null);
            $table->string('idnumber')->nullable()->default(null);
            $table->integer('director_id')->unsigned()->nullable()->default(null);
            $table->integer('innkeeper_id')->unsigned()->nullable()->default(null);
            $table->integer('assistant_id')->unsigned()->nullable()->default(null);
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
        Schema::drop('event');
    }
}
