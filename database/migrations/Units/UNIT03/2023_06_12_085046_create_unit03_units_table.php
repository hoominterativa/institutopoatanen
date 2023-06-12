<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnit03UnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit03_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('unit03_units_categories');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('path_image')->nullable();
            $table->string('path_image_icon')->nullable();
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
        Schema::dropIfExists('unit03_units');
    }
}
