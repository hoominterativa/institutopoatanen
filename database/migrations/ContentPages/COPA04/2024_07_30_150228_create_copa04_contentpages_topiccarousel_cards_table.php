<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa04ContentpagesTopiccarouselCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa04_contentpages_topiccarousel_cards', function (Blueprint $table) {
            $table->id();
            $table->String('title')->nullable();
            $table->String('subtitle')->nullable();
            $table->String('description')->nullable();
            $table->String('path_image')->nullable();
            $table->integer('sorting')->default(0);
            $table->boolean('active')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('copa04_contentpages_topiccarousel_cards');
    }
}
