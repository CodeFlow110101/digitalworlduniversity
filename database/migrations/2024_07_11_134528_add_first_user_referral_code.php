<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ReferralCode;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        ReferralCode::create(['user_id' => 1, 'code' => (string) Str::uuid() . '1' . 'test']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
