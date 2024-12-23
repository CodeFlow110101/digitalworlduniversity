<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WithdrawalMethod extends Model
{
    protected $table = "withdrawal_methods";

    protected $fillable = ['name'];

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'method_id', 'id');
    }
}
