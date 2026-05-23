<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('weekly_editions', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->date('edition_date')->nullable();
            $table->timestamp('publish_start_date')->nullable();
        });

        Schema::create('weekly_edition_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'weekly_edition');
        });

        Schema::create('weekly_edition_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'weekly_edition');
        });
    }

    public function down()
    {
        Schema::dropIfExists('weekly_edition_revisions');
        Schema::dropIfExists('weekly_edition_slugs');
        Schema::dropIfExists('weekly_editions');
    }
};
