<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = "find_jobs";

    protected $fillable = ['title', 'description', 'created_by', 'url', 'image', 'is_approved', 'image_url'];
}
