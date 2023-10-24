<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbou01AboutsSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abou01_abouts_sections', function (Blueprint $table) {
            $table->id();
            //Section home
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->text('description_section')->nullable();
            $table->string('path_image_section_desktop')->nullable();
            $table->string('path_image_section_mobile')->nullable();
            $table->string('background_color_section')->nullable();
            $table->integer('active_section')->default(0);
            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_banner_desktop')->nullable();
            $table->string('path_image_banner_mobile')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active_banner')->default(0);

            //Section topic
            $table->string('path_image_topic_desktop')->nullable();
            $table->string('path_image_topic_mobile')->nullable();
            $table->string('background_color_topic')->nullable();
            $table->integer('active_topic')->default(0);

            //Content
            $table->string('title_content')->nullable();
            $table->string('subtitle_content')->nullable();
            $table->text('text_content')->nullable();
            $table->string('title_button_content')->nullable();
            $table->string('link_button_content')->nullable();
            $table->enum('target_link_button_content', ['_self', '_blank'])->default('_blank');
            $table->string('path_image_content')->nullable();
            $table->string('path_image_content_desktop')->nullable();
            $table->string('path_image_content_mobile')->nullable();
            $table->string('background_color_content')->nullable();
            $table->integer('active_content')->default(0);
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
        Schema::dropIfExists('abou01_abouts_sections');
    }
}
