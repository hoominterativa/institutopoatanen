<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopi13TopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topi13_topics', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->string('title_button')->nullable();
            $table->string('link_button')->nullable();
            $table->enum('target_link', ['_self', '_blank'])->default('_self');
            $table->string('path_image_icon')->nullable();
            $table->string('path_image_desktop')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->string('color')->nullable();
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('topi13_topics');
    }
}
