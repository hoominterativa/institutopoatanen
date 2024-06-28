<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ12ServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv12_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('serv12_services_categories')->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->text('path_image')->nullable();
            $table->text('path_image_icon')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('featured')->default(0);
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
        Schema::dropIfExists('serv12_services');
    }
}
