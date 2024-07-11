<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralIncome extends Model
{
    use HasFactory;

    protected $table = 'referral_income';

    protected $fillable = ['user_id', 'amount'];
}
