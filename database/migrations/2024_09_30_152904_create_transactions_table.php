<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double('pg_service_charge_bdt')->nullable();
            $table->double('amount_original')->nullable();
            $table->string('gateway_fee')->nullable();
            $table->string('pg_service_charge_usd')->nullable();
            $table->text('pg_card_bank_name')->nullable();
            $table->text('pg_card_bank_country')->nullable();
            $table->text('card_number')->nullable();
            $table->text('card_holder')->nullable();
            $table->integer('status_code')->nullable();
            $table->string('pay_status')->nullable();
            $table->string('cus_name')->nullable();
            $table->string('cus_email')->nullable();
            $table->string('cus_phone')->nullable();
            $table->string('currency_merchant')->nullable();
            $table->string('convertion_rate')->nullable();
            $table->string('ip_address')->nullable();
            $table->double('other_currency')->nullable();
            $table->double('amount_currency')->nullable();
            $table->string('pg_txnid')->nullable();
            $table->string('epw_txnid')->nullable();
            $table->text('mer_txnid')->nullable();
            $table->string('store_id')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('currency')->nullable();
            $table->double('store_amount')->nullable();
            $table->string('pay_time')->nullable();
            $table->double('amount')->nullable();
            $table->text('bank_txn')->nullable();
            $table->string('card_type')->nullable();
            $table->text('reason')->nullable();
            $table->integer('pg_card_risklevel')->nullable();
            $table->text('pg_error_code_details')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
