<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ04ServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv04_services', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('category_id')->constrained('serv04_services_categories');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('slug')->nullable();
            $table->text('text')->nullable();
            $table->string('description')->nullable();
            $table->string('path_image')->nullable();
            $table->string('path_image_box')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->string('background_color')->nullable();
            $table->integer('featured')->default(0);
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
        Schema::dropIfExists('serv04_services');
    }
}
