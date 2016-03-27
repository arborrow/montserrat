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
            $table->string('contact_type')->nullable()->default(NULL);
            $table->string('subcontact_type')->nullable()->default(NULL);
            $table->boolean('do_not_email')->default(0);
            $table->boolean('do_not_phone')->default(0);
            $table->boolean('do_not_mail')->default(0);
            $table->boolean('do_not_sms')->default(0);
            $table->boolean('do_not_trade')->default(0);
            $table->boolean('is_opt_out')->default(0);
            $table->string('legal_identifier')->nullable()->default(NULL);
            $table->string('external_identifier')->nullable()->default(NULL);
            $table->string('sort_name')->nullable()->default(NULL);
            $table->string('display_name')->nullable()->default(NULL);
            $table->string('nick_name')->nullable()->default(NULL);
            $table->string('legal_name')->nullable()->default(NULL);
            $table->string('image_URL')->nullable()->default(NULL);
            $table->string('preferred_communication_method')->nullable()->default(NULL);
            $table->string('preferred_language')->nullable()->default(NULL);
            $table->enum('preferred_mail_format',['Text','HTML','Both'])->nullable()->default(NULL); 
            $table->string('hash')->nullable()->default(NULL);
            $table->string('api_key')->nullable()->default(NULL);
            $table->string('source')->nullable()->default(NULL);
            $table->string('first_name')->nullable()->default(NULL);
            $table->string('middle_name')->nullable()->default(NULL);
            $table->string('last_name')->nullable()->default(NULL);
            $table->integer('prefix_id')->nullable()->default(NULL);
            $table->integer('suffix_id')->nullable()->default(NULL);
            $table->integer('email_greeting_id')->nullable()->default(NULL);
            $table->string('email_greeting_custom')->nullable()->default(NULL);
            $table->string('email_greeting_display')->nullable()->default(NULL);
            $table->integer('postal_greeting_id')->nullable()->default(NULL);
            $table->string('postal_greeting_custom')->nullable()->default(NULL);
            $table->string('postal_greeting_display')->nullable()->default(NULL);
            $table->integer('addressee_id')->nullable()->default(NULL);
            $table->string('addressee_greeting_custom')->nullable()->default(NULL);
            $table->string('addressee_greeting_display')->nullable()->default(NULL);
            $table->string('job_title')->nullable()->default(NULL);
            $table->integer('gender_id')->nullable()->default(NULL);
            $table->date('birth_date')->nullable()->default(NULL);
            $table->boolean('is_deceased')->nullable()->default(NULL);
            $table->date('deceased_date')->nullable()->default(NULL);
            $table->string('household_name')->nullable()->default(NULL);
            $table->integer('primary_contact_id')->nullable()->default(NULL);
            $table->string('organization_name')->nullable()->default(NULL);
            $table->string('sic_code')->nullable()->default(NULL);
            $table->string('user_unique_id')->nullable()->default(NULL);
            $table->integer('employer_id')->nullable()->default(NULL);
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
