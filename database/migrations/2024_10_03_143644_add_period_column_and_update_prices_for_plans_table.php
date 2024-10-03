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
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('period')->nullable();
        });

        Plan::where('name', 'Cadet')->update([
            'price' => 999,
            'period' => 1,
        ]);

        Plan::where('name', 'Challenger')->update([
            'price' => 2799,
            'period' => 3,
        ]);

        Plan::where('name', 'Challenger')->update([
            'price' => 5699,
            'period' => 6,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
