<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCont07ContentsSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont07_contents_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->string('title_button')->nullable();
            $table->string('link_button')->nullable();
            $table->enum('target_link_button', ['_self', '_blank'])->default('_self');
            $table->string('path_image_desktop')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->string('background_color')->nullable();
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('cont07_contents_sections');
    }
}
