<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWowi01WorkwithTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wowi01_workwith', function (Blueprint $table) {
            $table->id();
            $table->string('title_banner')->nullable();
            $table->string('path_image_banner')->nullable();

            $table->string('title_box')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->string('path_image_thumbnail')->nullable();

            $table->string('title_content')->nullable();
            $table->string('subtitle_content')->nullable();
            $table->text('description_content')->nullable();
            $table->string('path_image_content')->nullable();
            $table->string('link_content')->nullable();
            $table->enum('link_target_content',['_self', '_blank'])->default('_self');

            $table->integer('featured_menu')->default(0);
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
        Schema::dropIfExists('wowi01_workwith');
    }
}
