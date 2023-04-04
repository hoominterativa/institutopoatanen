<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlid02SlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slid02_slides', function (Blueprint $table) {
            $table->id();
            $table->string('path_image_desktop')->nullable();
            $table->text('link')->nullable();
            $table->enum('target_link',['_self', '_blank'])->default('_self');
            $table->integer('active')->default(0);

            $table->string('path_image_mobile')->nullable();
            $table->string('link_mobile')->nullable();
            $table->enum('target_link_mobile',['_self', '_blank'])->default('_self');
            $table->integer('active_mobile')->default(0);

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
        Schema::dropIfExists('slid02_slides');
    }
}
