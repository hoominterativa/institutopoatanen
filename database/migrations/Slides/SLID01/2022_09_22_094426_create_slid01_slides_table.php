<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlid01SlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slid01_slides', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('description')->nullable();
            $table->string('title_button')->nullable();
            $table->string('link_button')->nullable();
            $table->string('path_image_desktop')->nullable();
            $table->string('path_image_png')->nullable();
            $table->enum('target_link_button',['_self', '_blank'])->default('_self');
            $table->enum('position_content',['center','start','end'])->default('start');
            $table->integer('active')->default(0);

            $table->string('title_mobile')->nullable();
            $table->string('subtitle_mobile')->nullable();
            $table->string('description_mobile')->nullable();
            $table->string('title_button_mobile')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->string('link_button_mobile')->nullable();
            $table->enum('target_link_button_mobile',['_self', '_blank'])->default('_self');
            $table->integer('active_mobile')->default(0);

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
        Schema::dropIfExists('slid01_slides');
    }
}
