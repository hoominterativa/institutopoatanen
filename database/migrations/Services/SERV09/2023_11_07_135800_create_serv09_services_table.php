<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ09ServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv09_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('serv09_services_categories');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('title_info')->nullable();
            $table->string('informations')->nullable();
            $table->string('path_image')->nullable();
            $table->string('link')->nullable();
            $table->integer('active')->default(0);
            $table->integer('featured')->default(0);
            //Section Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->string('background_color')->nullable();
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
        Schema::dropIfExists('serv09_services');
    }
}
