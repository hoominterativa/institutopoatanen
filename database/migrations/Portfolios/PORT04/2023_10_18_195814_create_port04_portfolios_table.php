<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort04PortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port04_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('port04_portfolios_categories');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('text')->nullable();
            $table->string('path_image')->nullable();
            $table->string('title_box')->nullable();
            $table->text('description_box')->nullable();
            $table->string('path_image_box')->nullable();
            $table->string('path_image_icon_box')->nullable();
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
        Schema::dropIfExists('port04_portfolios');
    }
}
