<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ10ServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv10_services', function (Blueprint $table) {
            $table->id();
            //Services
            $table->foreignId('category_id')->constrained('serv10_services_categories');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('path_image')->nullable();
            $table->string('title_box')->nullable();
            $table->text('description_box')->nullable();
            $table->string('path_image_box')->nullable();
            $table->string('path_image_icon_box')->nullable();
            $table->integer('featured')->default(0);
            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);

            //Show page
            $table->string('title_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active_banner')->default(0);

            $table->string('title_content')->nullable();
            $table->string('subtitle_content')->nullable();
            $table->text('description_content')->nullable();
            $table->integer('active_content')->default(0);

            $table->string('title_topic')->nullable();
            $table->string('subtitle_topic')->nullable();
            $table->text('description_topic')->nullable();
            $table->integer('active_topic')->default(0);

            $table->string('title_gallery')->nullable();
            $table->text('description_gallery')->nullable();
            $table->integer('active_gallery')->default(0);

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
        Schema::dropIfExists('serv10_services');
    }
}
