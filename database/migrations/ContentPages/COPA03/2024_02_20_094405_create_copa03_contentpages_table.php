<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa03ContentpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa03_contentpages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('title_page')->nullable();
            $table->string('title_topic_section')->nullable();
            $table->string('subtitle_topic_section')->nullable();
            $table->string('title_video_section')->nullable();
            $table->string('subtitle_video_section')->nullable();
            $table->string('path_image_banner_desktop')->nullable();
            $table->string('path_image_banner_mobile')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('copa03_contentpages');
    }
}
