<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbou05AboutsContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abou05_abouts_contents', function (Blueprint $table) {
            $table->id();
            //page
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('text')->nullable();
            $table->string('path_image')->nullable();
            //Lightbox
            $table->string('title_inner')->nullable();
            $table->string('subtitle_inner')->nullable();
            $table->text('text_inner')->nullable();
            $table->string('path_image_inner')->nullable();

            $table->integer('active')->default(0);
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
        Schema::dropIfExists('abou05_abouts_contents');
    }
}
