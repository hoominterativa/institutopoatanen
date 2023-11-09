<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbou04AboutsGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abou04_abouts_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained('abou04_abouts');
            $table->foreignId('category_id')->constrained('abou04_abouts_categories');
            $table->string('title')->nullable();
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
        Schema::dropIfExists('abou04_abouts_galleries');
    }
}
