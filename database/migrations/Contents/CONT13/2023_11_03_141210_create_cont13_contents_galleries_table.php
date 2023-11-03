<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCont13ContentsGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont13_contents_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained('cont13_contents');
            $table->string('path_image')->nullable();
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
        Schema::dropIfExists('cont13_contents_galleries');
    }
}
