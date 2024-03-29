<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->integer('contact_id')->unsigned()->nullable()->index('financial_account_contact_id_foreign');
            $table->integer('financial_account_type_id')->unsigned()->default(3);
            $table->string('accounting_code')->nullable();
            $table->string('account_type_code')->nullable();
            $table->string('description')->nullable();
            $table->integer('parent_id')->unsigned()->nullable()->index('financial_account_parent_id_foreign');
            $table->boolean('is_header_account')->nullable()->default(0);
            $table->boolean('is_deductible')->nullable()->default(1);
            $table->boolean('is_tax')->nullable()->default(0);
            $table->decimal('tax_rate', 10, 8)->nullable();
            $table->boolean('is_reserved')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->boolean('is_default')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_account');
    }
};
