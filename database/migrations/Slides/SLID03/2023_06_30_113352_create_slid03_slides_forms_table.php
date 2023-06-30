<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlid03SlidesFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slid03_slides_forms', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('title_lightbox')->nullable();
            $table->text('description_lightbox')->nullable();
            $table->string('path_image_lightbox')->nullable();
            $table->text('inputs')->nullable();
            $table->text('inputs_additionals')->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('slid03_slides_forms');
    }
}
