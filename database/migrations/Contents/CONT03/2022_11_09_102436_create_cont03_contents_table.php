<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCont03ContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont03_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('title_button')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->enum('link_target',['_self','_blank'])->default('_self');
            $table->string('path_image_center')->nullable();
            $table->string('path_image_right')->nullable();
            $table->string('path_image_background')->nullable();
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
        Schema::dropIfExists('cont03_contents');
    }
}
