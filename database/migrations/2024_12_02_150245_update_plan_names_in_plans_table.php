<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Plan::where('name', 'Cadet')->update(['name' => 'starter']);
        Plan::where('name', 'Challenger')->update(['name' => 'advance']);
        Plan::where('name', 'Champion')->update(['name' => 'experienced']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
