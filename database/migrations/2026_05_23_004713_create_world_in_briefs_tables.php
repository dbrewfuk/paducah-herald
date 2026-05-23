<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('world_in_briefs', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();      // the headline
            $table->string('region', 100)->nullable();     // "United States", "Middle East", etc.
            $table->longText('body')->nullable();
            $table->timestamp('publish_start_date')->nullable();
        });

        Schema::create('world_in_brief_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'world_in_brief');
        });
    }

    public function down()
    {
        Schema::dropIfExists('world_in_brief_revisions');
        Schema::dropIfExists('world_in_briefs');
    }
};
