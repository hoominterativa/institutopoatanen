<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGall03GalleriesSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gall03_galleries_sections', function (Blueprint $table) {
            $table->id();
            //Section Home
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->integer('active_section')->default(0);
            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->string('background_color')->nullable();
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
        Schema::dropIfExists('gall03_galleries_sections');
    }
}
