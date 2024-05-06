<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ08ServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv08_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('serv08_services_categories')->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->string('title_price')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('title_featured_service')->nullable();
            $table->string('color_featured_service')->nullable();
            $table->boolean('featured_service')->default(0);
            $table->text('path_image')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('featured')->default(0);
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
        Schema::dropIfExists('serv08_services');
    }
}
