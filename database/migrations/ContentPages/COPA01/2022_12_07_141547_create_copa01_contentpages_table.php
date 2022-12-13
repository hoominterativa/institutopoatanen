<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa01ContentpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa01_contentpages', function (Blueprint $table) {
            $table->id();
            $table->string('title_page')->nullable();
            $table->string('slug')->nullable();
            $table->string('title_banner')->nullable();
            $table->string('path_image_banner')->nullable();
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
        Schema::dropIfExists('copa01_contentpages');
    }
}
