<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->integer('position')->unsigned()->nullable();
        });

        Schema::create('section_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'section');
        });

        Schema::create('section_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'section');
        });
    }

    public function down()
    {
        Schema::dropIfExists('section_revisions');
        Schema::dropIfExists('section_slugs');
        Schema::dropIfExists('sections');
    }
};
