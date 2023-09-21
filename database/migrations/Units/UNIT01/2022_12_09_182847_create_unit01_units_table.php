<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnit01UnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit01_units', function (Blueprint $table) {
            $table->id();
            $table->string('title_unit')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('active')->default(0);
            $table->integer('featured')->default(0);
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
        Schema::dropIfExists('unit01_units');
    }
}
