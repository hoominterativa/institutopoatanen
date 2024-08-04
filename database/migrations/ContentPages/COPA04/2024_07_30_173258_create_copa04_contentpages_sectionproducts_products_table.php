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
            $table->index('contentpage_id', 'fk_contentpage_products_idx');
            $table->foreignId('contentpage_id')->constrained('copa04_contentpages')->name('fk_contentpage_products_idx');
            $table->string('title');
            $table->string('subtitle');
            $table->string('description');
            $table->string('value');
            $table->string('button_text');
            $table->string('button_link');
            $table->boolean('promotion')->default(0);
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
