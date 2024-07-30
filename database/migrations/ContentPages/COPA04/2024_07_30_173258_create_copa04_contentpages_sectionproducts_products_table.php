<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa04ContentpagesSectionproductsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa04_contentpages_sectionproducts_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('copa04_contentpages_sectionproducts_products');
    }
}
