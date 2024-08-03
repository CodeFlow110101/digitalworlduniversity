<?php

use App\Models\Channel;
use App\Models\Chat;
use App\Models\Group;
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
        Channel::where('id', '!=', 0)->delete();
        Group::where('id', '!=', 0)->delete();
        Chat::where('id', '!=', 0)->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
