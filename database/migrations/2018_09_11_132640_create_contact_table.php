<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_type')->nullable();
            $table->integer('subcontact_type')->nullable();
            $table->boolean('do_not_email')->default(0);
            $table->boolean('do_not_phone')->default(0);
            $table->boolean('do_not_mail')->default(0);
            $table->boolean('do_not_sms')->default(0);
            $table->boolean('do_not_trade')->default(0);
            $table->boolean('is_opt_out')->default(0);
            $table->string('legal_identifier')->nullable();
            $table->string('external_identifier')->nullable();
            $table->string('sort_name')->nullable();
            $table->string('display_name')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('legal_name')->nullable();
            $table->string('image_URL')->nullable();
            $table->string('preferred_communication_method')->nullable();
            $table->string('preferred_language')->nullable();
            $table->enum('preferred_mail_format', ['Text', 'HTML', 'Both'])->nullable();
            $table->string('hash')->nullable();
            $table->string('api_key')->nullable();
            $table->string('source')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('prefix_id')->nullable();
            $table->integer('suffix_id')->nullable();
            $table->integer('email_greeting_id')->nullable();
            $table->string('email_greeting_custom')->nullable();
            $table->string('email_greeting_display')->nullable();
            $table->integer('postal_greeting_id')->nullable();
            $table->string('postal_greeting_custom')->nullable();
            $table->string('postal_greeting_display')->nullable();
            $table->integer('addressee_id')->nullable();
            $table->string('addressee_greeting_custom')->nullable();
            $table->string('addressee_greeting_display')->nullable();
            $table->string('job_title')->nullable();
            $table->integer('gender_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean('is_deceased')->nullable();
            $table->date('deceased_date')->nullable();
            $table->string('household_name')->nullable();
            $table->integer('primary_contact_id')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('sic_code')->nullable();
            $table->string('user_unique_id')->nullable();
            $table->integer('employer_id')->nullable();
            $table->boolean('is_deleted')->nullable()->default(0);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified_date')->nullable();
            $table->softDeletes();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->integer('ethnicity_id')->unsigned()->nullable();
            $table->integer('religion_id')->unsigned()->nullable();
            $table->integer('occupation_id')->unsigned()->nullable();
            $table->integer('sort_name_count')->unsigned()->nullable();
            $table->integer('ppd_id')->unsigned()->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact');
    }
}
