<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\LkUserPlan;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $currentDate = Carbon::now();

        LkUserPlan::create(['user_id' => 1, 'plan_id' => 3, 'expiry_date' => $currentDate->addMonths(3)]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lk_user_plans', function (Blueprint $table) {
            //
        });
    }
};
