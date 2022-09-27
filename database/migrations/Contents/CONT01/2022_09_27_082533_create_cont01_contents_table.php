<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCont01ContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont01_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191)->nullable();
            $table->string('subtitle', 191)->nullable();
            $table->string('link', 191)->nullable();
            $table->enum('target_link', ['_self', '_blank', '_lightbox'])->default('_lightbox');
            $table->string('path_image', 191)->nullable();
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
        Schema::dropIfExists('cont01_contents');
    }
}
