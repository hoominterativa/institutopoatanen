<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ12ServicesVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv12_services_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('serv12_services')->onDelete('cascade');
            $table->string('link')->nullable();
            $table->string('path_image')->nullable();
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('serv12_services_videos');
    }
}
