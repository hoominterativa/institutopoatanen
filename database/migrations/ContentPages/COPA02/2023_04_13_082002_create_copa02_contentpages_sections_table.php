<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa02ContentpagesSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa02_contentpages_sections', function (Blueprint $table) {
            $table->id();
            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active_banner')->default(0);
            //Content
            $table->string('title_content')->nullable();
            $table->string('subtitle_content')->nullable();
            $table->text('description_content')->nullable();
            $table->string('path_image_desktop_content')->nullable();
            $table->string('path_image_mobile_content')->nullable();
            $table->string('background_color_content')->nullable();
            $table->integer('active_content')->default(0);
            //Section topics
            $table->string('title_section_topic')->nullable();
            $table->string('subtitle_section_topic')->nullable();
            $table->text('description_section_topic')->nullable();
            $table->integer('active_section_topic')->default(0);
            //Last content
            $table->string('title_last_section')->nullable();
            $table->string('subtitle_last_section')->nullable();
            $table->text('description_last_section')->nullable();
            $table->string('path_image_box_last_section')->nullable();
            $table->string('path_image_desktop_last_section')->nullable();
            $table->string('path_image_mobile_last_section')->nullable();
            $table->string('background_color_last_section')->nullable();
            $table->string('title_button_last_section')->nullable();
            $table->string('link_button_last_section')->nullable();
            $table->enum('target_link_button_last_section', ['_self', '_blank'])->default('_self');
            $table->integer('active_last_section')->default(0);
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
        Schema::dropIfExists('copa02_contentpages_sections');
    }
}
