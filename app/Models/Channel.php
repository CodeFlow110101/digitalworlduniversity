<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    use HasFactory;

    protected $table = "channels";

    protected $fillable = ['name', 'thumbmail', 'thumbnail_url', 'program_id'];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'channel_id', 'id');
    }
}
