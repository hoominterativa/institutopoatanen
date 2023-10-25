<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBran01BrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bran01_brands', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable();
            $table->enum('target_link', ['_self','_blank'])->default('_self');
            $table->string('path_image_icon')->nullable();
            $table->string('path_image_box')->nullable();
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
        Schema::dropIfExists('bran01_brands');
    }
}
