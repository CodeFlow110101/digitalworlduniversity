<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EarnMoneyResponse extends Model
{
    protected $table = "earn_money_responses";

    protected $fillable = ['user_id', 'question_id', 'option_id'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(EarnMoneyQuestion::class, 'question_id', 'id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(EarnMoneyOption::class, 'option_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
