<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Channel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Channel::create(['name' => 'Laravel']);
        Channel::create(['name' => 'Wordpress']);
        Channel::create(['name' => 'React js']);
        Channel::create(['name' => 'Angular js']);
        Channel::create(['name' => 'Django']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('channels', function (Blueprint $table) {
            //
        });
    }
};
