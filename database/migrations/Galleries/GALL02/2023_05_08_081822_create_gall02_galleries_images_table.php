<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGall02GalleriesImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gall02_galleries_images', function (Blueprint $table) {
            $table->id();
            $table->string('path_image')->nullable();
            $table->foreignId('gallery_id')->constrained('gall02_galleries');
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
        Schema::dropIfExists('gall02_galleries_images');
    }
}
