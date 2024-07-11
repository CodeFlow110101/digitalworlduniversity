<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkUserPlan extends Model
{
    use HasFactory;

    protected $table = 'lk_user_plans';

    protected $fillable = [
        'plan_id',
        'user_id',
        'expiry_date',
    ];
}
