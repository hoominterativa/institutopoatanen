<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa01ContentpagesSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa01_contentpages_sections', function (Blueprint $table) {
            $table->id();
            //Banner
            $table->string('title')->nullable();
            $table->string('path_image_desktop')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->string('background_color')->nullable();
            $table->integer('active_banner')->default(0);
            //Section
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->text('description_section')->nullable();
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
        Schema::dropIfExists('copa01_contentpages_sections');
    }
}
