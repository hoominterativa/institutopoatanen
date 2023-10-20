<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSche02SchedulesSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sche02_schedules_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->text('description_section')->nullable();
            $table->string('path_image_section')->nullable();
            $table->string('path_image_desktop_section')->nullable();
            $table->string('path_image_mobile_section')->nullable();
            $table->string('background_color_section')->nullable();
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->string('background_color_banner')->nullable();
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
        Schema::dropIfExists('sche02_schedules_sections');
    }
}
