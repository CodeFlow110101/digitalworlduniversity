<?php

use App\Models\Withdrawal;
use App\Models\WithdrawalStatus;
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
        Schema::create('withdrawal_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        WithdrawalStatus::create(['name' => 'open']);
        WithdrawalStatus::create(['name' => 'rejected']);
        WithdrawalStatus::create(['name' => 'passed']);
        WithdrawalStatus::create(['name' => 'completed']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_statuses');
    }
};
