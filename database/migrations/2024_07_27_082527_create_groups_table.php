<?php

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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id');
            $table->string('name');
            $table->timestamps();
        });

        Group::where('id', 1)->create(['channel_id' => 1, 'name' => 'Discussion 1']);
        Group::where('id', 1)->create(['channel_id' => 1, 'name' => 'Discussion 2']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
