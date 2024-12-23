<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WithdrawalStatus extends Model
{
    protected $table = "withdrawal_statuses";

    protected $fillable = ['name'];

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'status_id', 'id');
    }
}
