<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa04ContentpagesTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa04_contentpages_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191)->nullable();
            $table->string('subtitle', 191)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('color_one', 100)->nullable();
            $table->text('link', 200)->nullable();
            $table->string('btn_title',191)->nullable();
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
        Schema::dropIfExists('copa04_contentpages_topics');
    }
}
