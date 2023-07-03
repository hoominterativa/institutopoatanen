<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProd05ProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod05_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained('prod05_products_categories');
            $table->foreignId('subcategory_id')->constrained('prod05_products_subcategories');

            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->string('path_image_thumbnail')->nullable();
            $table->string('path_image')->nullable();
            $table->string('link')->nullable();
            $table->enum('link_target', ['_blank', '_self'])->default('_self');
            $table->string('title_button')->nullable();

            $table->string('path_image_banner')->nullable();
            $table->string('path_image_banner_mobile')->nullable();
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();

            $table->string('title_section_topic')->nullable();
            $table->string('subtitle_section_topic')->nullable();

            $table->integer('featured_home')->default(0);
            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('prod05_products');
    }
}
