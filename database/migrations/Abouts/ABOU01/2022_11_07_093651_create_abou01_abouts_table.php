<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbou01AboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abou01_abouts', function (Blueprint $table) {
            $table->id();

            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->text('description_section')->nullable();

            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_banner')->nullable();

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('text')->nullable();

            $table->string('title_inner_section')->nullable();
            $table->string('subtitle_inner_section')->nullable();
            $table->string('path_image_inner_section')->nullable();
            $table->text('text_inner_section')->nullable();
            $table->string('path_image_section_desktop')->nullable();
            $table->string('path_image_section_mobile')->nullable();
            $table->string('path_image')->nullable();

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
        Schema::dropIfExists('abou01_abouts');
    }
}
