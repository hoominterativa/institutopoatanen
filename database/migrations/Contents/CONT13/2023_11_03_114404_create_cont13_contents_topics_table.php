<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCont13ContentsTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont13_contents_topics', function (Blueprint $table) {
            $table->id();
            $table->string('path_image')->nullable();
            $table->text('link')->nullable();
            $table->enum('target_link', ['_self', '_blank'])->default('_blank');
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
        Schema::dropIfExists('cont13_contents_topics');
    }
}
