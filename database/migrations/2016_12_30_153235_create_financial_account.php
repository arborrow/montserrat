<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index('UI_name');
            $table->integer('contact_id')->unsigned()->nullable()->default(null);
            $table->integer('financial_account_type_id')->unsigned()->default(3);
            $table->string('accounting_code')->nullable()->default(null);
            $table->string('account_type_code')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->boolean('is_header_account')->nullable()->default(0);
            $table->boolean('is_deductible')->nullable()->default(1);
            $table->boolean('is_tax')->nullable()->default(0);
            $table->decimal('tax_rate', 10, 8)->nullable()->default(null);
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->boolean('is_default')->nullable()->default(0);
            $table->timestamps();
            
            $table->foreign('contact_id')->references('id')->on('contact');
            $table->foreign('parent_id')->references('id')->on('financial_account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('financial_account');
    }
}
