<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa04ContentpagesSectionheroesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa04_contentpages_sectionheroes', function (Blueprint $table) {
            $table->id();
            $table->index('contentpage_id', 'fk_contentpage_sectionheroes_idx');
            $table->foreignId('contentpage_id')->constrained('copa04_contentpages')->name('fk_contentpage_sectionheroes_idx');
            $table->string('title', 191)->nullable();
            $table->enum('target_link_one', ['_self', '_blank'])->default('_self');
            $table->enum('target_link_two', ['_self', '_blank'])->default('_self');
            $table->string('description', 255)->nullable();
            $table->string('path_image', 191)->nullable();
            $table->string('path_logo', 191)->nullable();
            $table->string('path_icon', 191)->nullable();
            $table->string('color_one', 100)->nullable();
            $table->string('color_two', 100)->nullable();
            $table->string('color_three', 100)->nullable();
            $table->string('title_btn', 50)->nullable();
            $table->string('link', 255)->nullable();
            $table->string('button_text', 50)->nullable();
            $table->string('button_link', 255)->nullable();
            $table->integer('sorting')->default(0);
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('copa04_contentpages_sectionheroes');
    }
}
