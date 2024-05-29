<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnit05UnitsLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit05_units_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit05_units');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->enum('target_link', ['_self', '_blank'])->default('_self');
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
        Schema::dropIfExists('unit05_units_links');
    }
}
