<?php

use App\Models\WithdrawalMethod;
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
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        WithdrawalMethod::create(['name' => 'paypal']);
        WithdrawalMethod::create(['name' => 'payoneer']);
        WithdrawalMethod::create(['name' => 'payeer']);
        WithdrawalMethod::create(['name' => 'crypto']);
        WithdrawalMethod::create(['name' => 'bkash']);
        WithdrawalMethod::create(['name' => 'nagad']);
        WithdrawalMethod::create(['name' => 'rocket']);
        WithdrawalMethod::create(['name' => 'bank']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_methods');
    }
};
