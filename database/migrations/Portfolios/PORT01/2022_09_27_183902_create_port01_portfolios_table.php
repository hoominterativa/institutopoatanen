<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort01PortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port01_portfolios', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('colors')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->string('path_image_box')->nullable();
            $table->string('path_image_left')->nullable();
            $table->string('path_image_right')->nullable();

            $table->string('title_testimonial')->nullable();
            $table->string('subtitle_testimonial')->nullable();
            $table->text('text_testimonial')->nullable();
            $table->string('path_image_testimonial')->nullable();

            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);

            $table->foreignId('category_id')->constrained('port01_portfolios_categories');
            $table->foreignId('subcategory_id')->nullable()->constrained('port01_portfolios_subategories');

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
        Schema::dropIfExists('port01_portfolios');
    }
}
