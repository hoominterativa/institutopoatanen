<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ12ServicesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv12_services_categories', function (Blueprint $table) {
            $table->id();
            //Categories
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->text('path_image')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('featured')->default(0);
            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->text('path_image_desktop_banner')->nullable();
            $table->text('path_image_mobile_banner')->nullable();
            $table->boolean('active_banner')->default(0);
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
        Schema::dropIfExists('serv12_services_categories');
    }
}
