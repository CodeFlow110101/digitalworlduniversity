<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LkUserPlan extends Model
{
    use HasFactory;

    protected $table = 'lk_user_plans';

    protected $fillable = [
        'plan_id',
        'user_id',
        'expiry_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
