<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBran01BrandsSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bran01_brands_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_banner_desktop')->nullable();
            $table->string('path_image_banner_mobile')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active_banner')->default(0);

            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->text('description_section')->nullable();
            $table->string('path_image_section_desktop')->nullable();
            $table->string('path_image_section_mobile')->nullable();
            $table->string('background_color_section')->nullable();
            $table->integer('active_section')->default(0);

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
        Schema::dropIfExists('bran01_brands_sections');
    }
}
