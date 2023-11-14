<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort04PortfoliosSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port04_portfolios_sections', function (Blueprint $table) {
            $table->id();
            //Section home
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->text('text_section')->nullable();
            $table->integer('active_section')->default(0);
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
            $table->text('text_content')->nullable();
            $table->integer('active_content')->default(0);
            //Section relationship
            $table->string('title_relationship')->nullable();
            $table->string('subtitle_relationship')->nullable();
            $table->text('description_relationship')->nullable();
            $table->integer('active_relationship')->default(0);
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
        Schema::dropIfExists('port04_portfolios_sections');
    }
}
