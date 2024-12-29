<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EarnMoneyOption extends Model
{
    protected $table = 'earn_money_options';

    protected $fillable = ['question_id', 'text', 'is_correct'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(EarnMoneyQuestion::class, 'question_id', 'id');
    }
}
