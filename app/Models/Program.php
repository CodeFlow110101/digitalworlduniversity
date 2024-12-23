<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $table = "programs";

    protected $fillable = ['title', 'description', 'image', 'status_id', 'image_url'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProgramStatus::class, 'status_id', 'id');
    }
}
