<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProd05ProductsGallerysectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod05_products_gallerysections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('prod05_products');
            $table->string('path_image')->nullable();
            $table->string('link_video')->nullable();
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
        Schema::dropIfExists('prod05_products_gallerysections');
    }
}
