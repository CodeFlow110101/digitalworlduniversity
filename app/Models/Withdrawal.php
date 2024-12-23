<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Withdrawal extends Model
{
    protected $table = "withdrawals";

    protected $fillable = ['user_id', 'amount', 'name', 'email', 'method_id', 'payment_id', 'status_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(WithdrawalMethod::class, 'method_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(WithdrawalStatus::class, 'status_id', 'id');
    }
}
