<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBran02BrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bran02_brands', function (Blueprint $table) {
            $table->id();
            $table->string('title_home')->nullable();
            $table->string('subtitle_home')->nullable();
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('title_page')->nullable();
            $table->string('subtitle_page')->nullable();
            $table->text('description')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_text')->nullable();
            $table->enum('target_link', ['_self','_blank'])->default('_self');
            $table->boolean('active')->default(0);
            $table->integer('sorting')->default(0);
            $table->string('path_image')->nullable();
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
        Schema::dropIfExists('bran02_brands');
    }
}
