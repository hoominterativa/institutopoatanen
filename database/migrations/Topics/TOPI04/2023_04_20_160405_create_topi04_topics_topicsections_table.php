<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopi04TopicsTopicsectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topi04_topics_topicsections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('topi04_topics')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->string('path_image_box')->nullable();
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
        Schema::dropIfExists('topi04_topics_topicsections');
    }
}
