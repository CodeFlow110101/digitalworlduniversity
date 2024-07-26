<?php

use App\Models\User;
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
        User::where('id', 1)->update(['wallet' => 0, 'referral_income' => 0, 'task_income' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
