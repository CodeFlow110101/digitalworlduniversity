<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramStatus extends Model
{
    protected $table = 'program_statuses';

    protected $fillable = ['name'];

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'status_id', 'id');
    }
}
