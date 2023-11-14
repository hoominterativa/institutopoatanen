<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort04PortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port04_portfolios', function (Blueprint $table) {
            $table->id();
            //Portfólio
            $table->foreignId('category_id')->constrained('port04_portfolios_categories');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('path_image')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->integer('active')->default(0);
            $table->integer('featured')->default(0);
            //Internal Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active_banner')->default(0);
            //Internal Content
            $table->string('title_content')->nullable();
            $table->string('subtitle_content')->nullable();
            $table->text('text_content')->nullable();
            $table->string('path_image_content')->nullable();
            $table->integer('active_content')->default(0);
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
        Schema::dropIfExists('port04_portfolios');
    }
}
