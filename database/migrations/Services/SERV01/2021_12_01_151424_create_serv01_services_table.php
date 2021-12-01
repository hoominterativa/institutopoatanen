<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ01ServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv01_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->longText('text')->nullable();
            $table->string('path_image_box')->nullable();
            $table->string('path_image_inner')->nullable();
            $table->integer('sorting')->default(0);
            $table->timestamps();

            $table->index('category_id', 'fk_serv01_services_serv01_services_categories1_idx');
            $table->index('subcategory_id', 'fk_serv01_services_serv01_services_subcategories1_idx');

            $table->foreign('category_id', 'fk_serv01_services_serv01_services_categories1_idx')
                ->references('id')->on('serv01_services_categories')
                ->onDelete('no action')->onUpdate('no action');

            $table->foreign('subcategory_id', 'fk_serv01_services_serv01_services_subcategories1_idx')
                ->references('id')->on('serv01_services_subcategories')
                ->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serv01_services');
    }
}
