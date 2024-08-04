<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa04ContentpagesTopiccarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa04_contentpages_topiccarousels', function (Blueprint $table) {
            $table->id();
            $table->index('contentpage_id', 'fk_contentpage_topiccarousels_idx');
            $table->foreignId('contentpage_id')->constrained('copa04_contentpages')->name('fk_contentpage_topiccarousels_idx');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('description')->nullable();
            $table->string('color_one')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
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
        Schema::dropIfExists('copa04_contentpages_topiccarousels');
    }
}
