<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbou04AboutsSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abou04_abouts_sections', function (Blueprint $table) {
            $table->id();
            //Section
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->string('description_section')->nullable();
            $table->string('path_image_section')->nullable();
            $table->string('path_image_desktop_section')->nullable();
            $table->string('path_image_mobile_section')->nullable();
            $table->string('background_color_section')->nullable();
            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->string('background_color_banner')->nullable();
            //Section Galleries
            $table->string('title_galleries')->nullable();
            $table->text('description_galleries')->nullable();
            $table->string('title_button_galleries')->nullable();
            $table->string('link_button_galleries')->nullable();
            $table->enum('target_link_button_galleries', ['_self', '_blank'])->default('_self');
            //Section Topics
            $table->string('path_image_desktop_topics')->nullable();
            $table->string('path_image_mobile_topics')->nullable();
            $table->string('background_color_topics')->nullable();
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
        Schema::dropIfExists('abou04_abouts_sections');
    }
}
