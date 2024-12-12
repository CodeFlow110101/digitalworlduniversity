<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    protected $table = "chats";

    protected $fillable = ['user_id', 'message', 'group_id', 'is_archive', 'reply_to', 'file_name', 'file_path'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'group_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
