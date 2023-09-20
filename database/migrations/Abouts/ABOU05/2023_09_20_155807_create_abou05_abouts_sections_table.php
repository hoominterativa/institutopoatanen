<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbou05AboutsSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abou05_abouts_sections', function (Blueprint $table) {
            $table->id();
            //Section
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->string('description_section')->nullable();
            $table->string('path_image_desktop_section')->nullable();
            $table->string('path_image_mobile_section')->nullable();
            $table->string('background_color_section')->nullable();
            $table->integer('active_section')->default(0);
            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active_banner')->default(0);
            //Section Content
            $table->string('title_content')->nullable();
            $table->string('subtitle_content')->nullable();
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
        Schema::dropIfExists('abou05_abouts_sections');
    }
}
