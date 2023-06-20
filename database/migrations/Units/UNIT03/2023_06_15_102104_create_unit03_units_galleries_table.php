<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnit03UnitsGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit03_units_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit03_units');
            $table->string('title')->nullable();
            $table->text('link_video')->nullable();
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
        Schema::dropIfExists('unit03_units_galleries');
    }
}
