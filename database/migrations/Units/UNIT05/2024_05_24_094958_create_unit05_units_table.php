<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnit05UnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit05_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('unit05_units_categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained('unit05_units_subcategories')->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->text('path_image_icon')->nullable();
            $table->text('path_image_box')->nullable();
            $table->text('path_image')->nullable();
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('unit05_units');
    }
}
