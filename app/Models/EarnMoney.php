<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarnMoney extends Model
{
    use HasFactory;

    protected $table = "earn_money";

    protected $fillable = ['title', 'description', 'thumbmail', 'url'];
}
