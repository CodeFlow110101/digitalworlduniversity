<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'pg_service_charge_bdt',
        'amount_original',
        'password',
        'gateway_fee',
        'pg_service_charge_usd',
        'pg_card_bank_name',
        'pg_card_bank_country',
        'card_number',
        'card_holder',
        'status_code',
        'pay_status',
        'cus_name',
        'cus_email',
        'cus_phone',
        'currency_merchant',
        'convertion_rate',
        'ip_address',
        'other_currency',
        'amount_currency',
        'pg_txnid',
        'epw_txnid',
        'mer_txnid',
        'store_id',
        'merchant_id',
        'currency',
        'store_amount',
        'pay_time',
        'amount',
        'bank_txn',
        'card_type',
        'reason',
        'pg_card_risklevel',
        'pg_error_code_details',
        'user_id',
    ];
}
