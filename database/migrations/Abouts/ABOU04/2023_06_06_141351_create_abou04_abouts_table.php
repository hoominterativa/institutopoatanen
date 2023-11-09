<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbou04AboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abou04_abouts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('text')->nullable();
            $table->string('path_image')->nullable();
            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);

            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active_banner')->default(0);
            //Section Galleries
            $table->string('title_galleries')->nullable();
            $table->text('description_galleries')->nullable();
            $table->string('title_button_galleries')->nullable();
            $table->string('link_button_galleries')->nullable();
            $table->enum('target_link_button_galleries', ['_self', '_blank'])->default('_self');
            $table->integer('active_galleries')->default(0);
            //Section Topics
            $table->string('path_image_desktop_topics')->nullable();
            $table->string('path_image_mobile_topics')->nullable();
            $table->string('background_color_topics')->nullable();
            $table->integer('active_topics')->default(0);
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
        Schema::dropIfExists('abou04_abouts');
    }
}
