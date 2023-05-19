<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePota01PortalsPodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pota01_portals_podcasts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('duration')->nullable();
            $table->date('publishing')->nullable();
            $table->text('description')->nullable();
            $table->string('path_image_thumbnail')->nullable();
            $table->string('path_archive')->nullable();
            $table->text('embed')->nullable();
            $table->integer('featured_home')->nullable();
            $table->integer('active')->nullable();
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
        Schema::dropIfExists('pota01_portals_podcasts');
    }
}
