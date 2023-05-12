<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePota01PortalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pota01_portals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('pota01_portals_categories');
            $table->text('title')->nullable();
            $table->text('slug')->nullable();
            $table->date('publishing')->nullable();
            $table->text('description')->nullable();
            $table->longText('text')->nullable();
            $table->string('path_image_thumbnail')->nullable();
            $table->string('path_image')->nullable();
            $table->integer('active')->default(0);
            $table->integer('featured_home')->default(0);
            $table->integer('featured_page')->default(0);
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
        Schema::dropIfExists('pota01_portals');
    }
}
