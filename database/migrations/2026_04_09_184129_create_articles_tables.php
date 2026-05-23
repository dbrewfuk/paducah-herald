<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->string('fly_title', 120)->nullable();
            $table->text('standfirst')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedBigInteger('section_id')->nullable()->index();
            $table->tinyInteger('read_time')->unsigned()->nullable();
            $table->timestamp('publish_start_date')->nullable();
        });

        Schema::create('article_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'article');
        });

        
    }

    public function down()
    {
        
        Schema::dropIfExists('article_slugs');
        Schema::dropIfExists('articles');
    }
};
