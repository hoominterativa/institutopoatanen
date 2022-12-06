<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWowi01WorkwithTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wowi01_workwith_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workwith_id')->constrained('wowi01_workwith')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->string('path_image_thumbnail')->nullable();
            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);
            $table->string('link')->nullable();
            $table->enum('link_target',['_self', '_blank'])->default('_self');
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
        Schema::dropIfExists('wowi01_workwith_topics');
    }
}
