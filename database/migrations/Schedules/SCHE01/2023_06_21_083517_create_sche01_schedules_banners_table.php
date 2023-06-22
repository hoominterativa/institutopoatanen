<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSche01SchedulesBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sche01_schedules_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('path_image_desktop')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->string('background_color')->nullable();
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('sche01_schedules_banners');
    }
}
