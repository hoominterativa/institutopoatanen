<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort06PortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port06_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('port06_portfolios_categories');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('paragraph')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('path_image')->nullable();
            $table->text('path_image_box')->nullable();
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
        Schema::dropIfExists('port06_portfolios');
    }
}
