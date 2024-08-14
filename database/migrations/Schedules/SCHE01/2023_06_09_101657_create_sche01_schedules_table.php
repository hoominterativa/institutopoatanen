<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSche01SchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sche01_schedules', function (Blueprint $table) {
            $table->id();
            //Schedule
            $table->string('title')->nullable();
            $table->text('slug')->nullable();
            $table->string('subtitle')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->text('description')->nullable();
            $table->text('description_box')->nullable();
            $table->text('text')->nullable();
            $table->text('information')->nullable();
            $table->string('title_button')->nullable();
            $table->string('link_button')->nullable();
            $table->enum('target_link_button', ['_self', '_blank'])->default('_self');
            $table->string('path_image_box')->nullable();
            $table->string('path_image_sub')->nullable();
            $table->string('path_image_hours')->nullable();
            $table->string('path_image')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('featured')->default(0);
            //Banner inner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->boolean('active_banner')->default(0);

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
        Schema::dropIfExists('sche01_schedules');
    }
}
