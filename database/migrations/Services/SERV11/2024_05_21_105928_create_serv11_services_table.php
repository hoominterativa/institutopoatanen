<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ11ServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv11_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('serv11_services_sessions')->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->text('path_image_icon')->nullable();
            $table->text('path_image_box')->nullable();
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
        Schema::dropIfExists('serv11_services');
    }
}
