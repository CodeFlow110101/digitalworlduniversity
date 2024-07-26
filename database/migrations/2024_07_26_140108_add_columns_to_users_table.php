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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('wallet', 10, 2)->default(0);
            $table->decimal('referral_income', 10, 2)->default(0);
            $table->decimal('task_income', 10, 2)->default(0);
        });

        User::where('id', 1)->update(['wallet' => 150, 'referral_income' => 23, 'task_income' => 78]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
