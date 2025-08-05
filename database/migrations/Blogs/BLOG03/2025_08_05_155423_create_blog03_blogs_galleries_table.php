<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlog03BlogsGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog03_blogs_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blog03_blogs');
            $table->string('title')->nullable();
            $table->string('path_image')->nullable();
            $table->string('path_image_box')->nullable();
            $table->text('link_url')->nullable();
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
        Schema::dropIfExists('blog03_blogs_galleries');
    }
}
