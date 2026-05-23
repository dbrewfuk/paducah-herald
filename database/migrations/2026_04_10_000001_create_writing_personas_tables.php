<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('writing_personas', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('title', 200);
            $table->string('specialty', 100);
            $table->text('voice_description');
            $table->integer('position')->unsigned()->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('writing_personas');
    }
};
