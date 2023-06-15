<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnit03UnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit03_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('unit03_units_categories');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('path_image')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);

            $table->string('title_show')->nullable();
            $table->string('subtitle_show')->nullable();
            $table->string('path_image_icon_show')->nullable();

            $table->string('path_image_gallery')->nullable();
            $table->string('title_gallery')->nullable();
            $table->string('link_video')->nullable();

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
        Schema::dropIfExists('unit03_units');
    }
}
