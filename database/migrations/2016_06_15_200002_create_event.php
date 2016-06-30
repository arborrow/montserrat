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
            $table->string('title')->nullable()->default(NULL);
            $table->text('summary')->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->integer('event_type_id')->unsigned()->nullable()->default(0);
            $table->integer('participant_listing_id')->nullable()->unsigned()->default(0);
            $table->boolean('is_public')->nullable()->default(1);
            $table->datetime('start_date')->nullable()->default(NULL);
            $table->datetime('end_date')->nullable()->default(NULL);
            $table->boolean('is_online_registration')->nullable()->default(0);
            $table->string('registration_link_text')->nullable()->default(NULL);
            $table->datetime('registration_start_date')->nullable()->default(NULL);
            $table->datetime('registration-end_date')->nullable()->default(NULL);
            $table->integer('max_participants')->unsigned()->nullable()->default(NULL);
            $table->text('event_full_text')->nullable()->default(NULL);
            $table->boolean('is_monetary')->nullable()->default(0);
            $table->integer('financial_type_id')->unsigned()->nullable()->default(NULL);
            $table->string('payment_processor')->nullable()->default(NULL);
            $table->boolean('is_map')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->string('fee_label')->nullable()->default(NULL);
            $table->boolean('is_show_location')->nullable()->default(1);
            $table->integer('loc_block_id')->unsigned()->nullable()->default(NULL);
            $table->integer('default_role_id')->unsigned()->nullable()->default(1);
            $table->text('intro_text')->nullable()->default(NULL);
            $table->text('footer_text')->nullable()->default(NULL);
            $table->string('confirm_title')->nullable()->default(NULL);
            $table->text('confirm_text')->nullable()->default(NULL);
            $table->text('confirm_footer_text')->nullable()->default(NULL);
            $table->boolean('is_email_confirm')->nullable()->default(0);
            $table->text('confirm_email_text')->nullable()->default(NULL);
            $table->string('confirm_from_name')->nullable()->default(NULL);
            $table->string('confirm_from_email')->nullable()->default(NULL);
            $table->string('cc_confirm')->nullable()->default(NULL);
            $table->string('bc_confirm')->nullable()->default(NULL);
            $table->integer('default_fee_id')->unsigned()->nullable()->default(NULL);
            $table->integer('default_discount_fee_id')->unsigned()->nullable()->default(NULL);
            $table->string('thankyou_title')->nullable()->default(NULL);
            $table->text('thankyou_text')->nullable()->default(NULL);
            $table->text('thankyou_footer_text')->nullable()->default(NULL);
            $table->boolean('is_pay_later')->nullable()->default(0);
            $table->text('pay_later_text')->nullable()->default(NULL);
            $table->text('pay_later_receipt')->nullable()->default(NULL);
            $table->boolean('is_partial_payment')->nullable()->default(0);
            $table->string('initial_amount_label')->nullable()->default(NULL);
            $table->text('initial_amount_help_text')->nullable()->default(NULL);
            $table->decimal('min_initial_amount',20,2)->nullable()->default(NULL);
            $table->boolean('is_multiple_registrations')->nullable()->default(0);
            $table->boolean('allow_same_participant_emails')->nullable()->default(0);
            $table->boolean('has_waitlist')->nullable()->default(NULL);
            $table->boolean('requires_approval')->nullable()->default(NULL);
            $table->integer('expiration_time')->unsigned()->nullable()->default(NULL);
            $table->text('waitlist_text')->nullable()->default(NULL);
            $table->text('approval_req_text')->nullable()->default(NULL);
            $table->boolean('is_template')->nullable()->default(0);
            $table->string('template_title')->nullable()->default(NULL);
            $table->integer('created_id')->unsigned()->nullable()->default(NULL);
            $table->datetime('created_date')->nullable()->default(NULL);
            $table->string('currency',3)->nullable()->default(NULL);
            $table->integer('campaign_id')->unsigned()->nullable()->default(NULL);
            $table->boolean('is_share')->nullable()->default(1);
            $table->integer('parent_event_id')->unsigned()->nullable()->default(NULL);
            $table->integer('slot_label_id')->unsigned()->nullable()->default(NULL);
            $table->integer('retreat_id')->unsigned()->nullable()->default(NULL);
            $table->string('idnumber')->nullable()->default(NULL);
            $table->integer('director_id')->unsigned()->nullable()->default(NULL);
            $table->integer('innkeeper_id')->unsigned()->nullable()->default(NULL);
            $table->integer('assistant_id')->unsigned()->nullable()->default(NULL);
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
        Schema::drop('event'); //
    }
}
