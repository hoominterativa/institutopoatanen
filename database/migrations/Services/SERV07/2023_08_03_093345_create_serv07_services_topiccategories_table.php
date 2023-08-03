<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ07ServicesTopiccategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv07_services_topiccategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('serv07_services_categories');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('path_image')->nullable();
            $table->text('path_image_icon')->nullable();
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('serv07_services_topiccategories');
    }
}
