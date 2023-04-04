<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCont09ContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont09_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('link')->nullable();
            $table->text('path_image_desktop')->nullable();
            $table->text('path_image_mobile')->nullable();
            $table->text('backgound_color')->nullable();
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
        Schema::dropIfExists('cont09_contents');
    }
}
