<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->Increments('id')->unsigned;
            $table->string('contact_type')->nullable()->default(null);
            $table->string('subcontact_type')->nullable()->default(null);
            $table->boolean('do_not_email')->default(0);
            $table->boolean('do_not_phone')->default(0);
            $table->boolean('do_not_mail')->default(0);
            $table->boolean('do_not_sms')->default(0);
            $table->boolean('do_not_trade')->default(0);
            $table->boolean('is_opt_out')->default(0);
            $table->string('legal_identifier')->nullable()->default(null);
            $table->string('external_identifier')->nullable()->default(null);
            $table->string('sort_name')->nullable()->default(null);
            $table->string('display_name')->nullable()->default(null);
            $table->string('nick_name')->nullable()->default(null);
            $table->string('legal_name')->nullable()->default(null);
            $table->string('image_URL')->nullable()->default(null);
            $table->string('preferred_communication_method')->nullable()->default(null);
            $table->string('preferred_language')->nullable()->default(null);
            $table->enum('preferred_mail_format', ['Text','HTML','Both'])->nullable()->default(null);
            $table->string('hash')->nullable()->default(null);
            $table->string('api_key')->nullable()->default(null);
            $table->string('source')->nullable()->default(null);
            $table->string('first_name')->nullable()->default(null);
            $table->string('middle_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->integer('prefix_id')->nullable()->default(null);
            $table->integer('suffix_id')->nullable()->default(null);
            $table->integer('email_greeting_id')->nullable()->default(null);
            $table->string('email_greeting_custom')->nullable()->default(null);
            $table->string('email_greeting_display')->nullable()->default(null);
            $table->integer('postal_greeting_id')->nullable()->default(null);
            $table->string('postal_greeting_custom')->nullable()->default(null);
            $table->string('postal_greeting_display')->nullable()->default(null);
            $table->integer('addressee_id')->nullable()->default(null);
            $table->string('addressee_greeting_custom')->nullable()->default(null);
            $table->string('addressee_greeting_display')->nullable()->default(null);
            $table->string('job_title')->nullable()->default(null);
            $table->integer('gender_id')->nullable()->default(null);
            $table->date('birth_date')->nullable()->default(null);
            $table->boolean('is_deceased')->nullable()->default(null);
            $table->date('deceased_date')->nullable()->default(null);
            $table->string('household_name')->nullable()->default(null);
            $table->integer('primary_contact_id')->nullable()->default(null);
            $table->string('organization_name')->nullable()->default(null);
            $table->string('sic_code')->nullable()->default(null);
            $table->string('user_unique_id')->nullable()->default(null);
            $table->integer('employer_id')->nullable()->default(null);
            $table->boolean('is_deleted')->nullable()->default(0);
            $table->timestamp('created_date');
            $table->timestamp('modified_date');
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
        Schema::drop('contact');
    }
}
