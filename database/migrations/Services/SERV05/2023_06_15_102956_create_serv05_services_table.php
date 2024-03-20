<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ05ServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv05_services', function (Blueprint $table) {
            //Service
            $table->id();
            $table->foreignId('category_id')->constrained('serv05_services_categories')->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('title_price')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('path_image')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->integer('featured')->default(0);
            $table->integer('active')->default(0);

            //Topic
            $table->string('title_topic')->nullable();
            $table->string('subtitle_topic')->nullable();
            $table->string('title_topic_button')->nullable();
            $table->text('link_topic')->nullable();
            $table->enum('target_link', ['_self', '_blank'])->default('_self');
            $table->integer('active_topic')->default(0);

            //About
            $table->string('title_about_inner')->nullable();
            $table->string('subtitle_about_inner')->nullable();
            $table->text('description_about_inner')->nullable();
            $table->integer('active_about_inner')->default(0);

            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->integer('active_banner')->default(0);

            $table->integer('sorting')->default(0);
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
        Schema::dropIfExists('serv05_services');
    }
}
