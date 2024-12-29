<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EarnMoney extends Model
{
    use HasFactory;

    protected $table = "earn_money";

    protected $fillable = ['title', 'description', 'thumbmail', 'url', 'thumbnail_url'];

    public function questions(): HasMany
    {
        return $this->hasMany(EarnMoneyQuestion::class, 'survey_id', 'id');
    }
}
