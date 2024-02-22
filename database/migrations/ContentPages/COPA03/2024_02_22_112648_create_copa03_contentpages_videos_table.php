<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa03ContentpagesVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa03_contentpages_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subvideo_id')->constrained('copa03_contentpages_subcategoryvideos')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('path_archive')->nullable();
            $table->string('path_image')->nullable();
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
        Schema::dropIfExists('copa03_contentpages_videos');
    }
}
