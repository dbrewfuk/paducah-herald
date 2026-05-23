<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_scores', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('home_team', 100)->nullable();
            $table->string('away_team', 100)->nullable();
            $table->unsignedTinyInteger('home_score')->nullable();
            $table->unsignedTinyInteger('away_score')->nullable();
            $table->string('sport', 60)->nullable()->default('Baseball');
            $table->timestamp('game_date')->nullable();
            $table->string('status', 20)->nullable()->default('upcoming'); // upcoming | final | postponed
            $table->string('venue', 150)->nullable();
            $table->string('notes', 200)->nullable(); // e.g. "OT", "5 inn.", "Region Quarterfinal"
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_scores');
    }
};
