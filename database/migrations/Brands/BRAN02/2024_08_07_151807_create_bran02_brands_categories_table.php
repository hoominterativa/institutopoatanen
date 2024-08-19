<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBran02BrandsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bran02_brands_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('slug');
            $table->boolean('highlighted')->default(0);
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
        Schema::dropIfExists('bran02_brands_categories');
    }
}
