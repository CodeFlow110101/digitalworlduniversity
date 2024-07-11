<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ReferralIncome;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        ReferralIncome::create(['user_id' => 1, 'amount' => 23]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referral_income', function (Blueprint $table) {
            //
        });
    }
};
