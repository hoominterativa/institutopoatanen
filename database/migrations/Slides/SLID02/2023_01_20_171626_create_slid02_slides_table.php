<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlid02SlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slid02_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->string('path_image_background')->nullable();
            $table->text('link_button')->nullable();
            $table->enum('target_link_button',['_self', '_blank'])->default('_self');
            $table->integer('active')->default(0);

            $table->string('title_mobile')->nullable();
            $table->string('path_image_icon_mobile')->nullable();
            $table->string('path_image_background_mobile')->nullable();
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
        Schema::dropIfExists('slid02_slides');
    }
}
