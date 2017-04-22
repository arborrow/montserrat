<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // based off of the CiviCRM participant table
        // role_id field is of type varchar(128) in CiviCRM but making integer here
        // role_id should really be named participant_role_id but leaving as role_id as it is in CiviCRM
        Schema::create('participant', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('status_id')->unsigned()->default(1);
            $table->integer('role_id')->nullable()->unsigned()->default(5);
            $table->datetime('register_date')->nullable()->default(null);
            $table->string('source')->nullable()->default(null);
            $table->text('fee_level')->nullable()->default(null);
            $table->boolean('is_test')->nullable()->default(0);
            $table->boolean('is_pay_later')->nullable()->default(0);
            $table->decimal('fee_amount', 20, 2)->nullable()->default(null);
            $table->integer('registered_by_id')->unsigned()->nullable()->default(null);
            $table->integer('discount_id')->unsigned()->nullable()->default(null);
            $table->string('fee_currency', 3)->nullable()->default(null);
            $table->integer('campaign_id')->unsigned()->nullable()->default(null);
            $table->integer('discount_amount')->unsigned()->nullable()->default(null);
            $table->integer('cart_id')->unsigned()->nullable()->default(null);
            $table->integer('must_wait')->nullable()->default(null);
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
        Scheme::drop('participant');
    }
}
