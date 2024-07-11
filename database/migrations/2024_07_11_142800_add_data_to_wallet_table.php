<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Wallet;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Wallet::create(['user_id' => 1, 'amount' => 150]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet', function (Blueprint $table) {
            //
        });
    }
};
