<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('insider_episodes', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->text('episode_summary')->nullable();
            $table->string('sponsor_name', 120)->nullable();
            $table->string('video_url', 500)->nullable();
            $table->timestamp('publish_start_date')->nullable();
        });

        Schema::create('insider_episode_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'insider_episode');
        });

        Schema::create('insider_episode_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'insider_episode');
        });
    }

    public function down()
    {
        Schema::dropIfExists('insider_episode_revisions');
        Schema::dropIfExists('insider_episode_slugs');
        Schema::dropIfExists('insider_episodes');
    }
};
