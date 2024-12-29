<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EarnMoneyQuestion extends Model
{
    protected $table = "earn_money_questions";

    protected $fillable = ['survey_id', 'text'];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(EarnMoney::class, 'survey_id', 'id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(EarnMoneyOption::class, 'question_id', 'id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(EarnMoneyResponse::class, 'question_id', 'id');
    }
}
