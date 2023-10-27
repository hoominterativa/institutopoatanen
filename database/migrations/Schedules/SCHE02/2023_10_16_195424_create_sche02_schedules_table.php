<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSche02SchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sche02_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('event_locale')->nullable();
            $table->string('event_title')->nullable();
            $table->date('event_date')->nullable();
            $table->text('informations')->nullable();
            $table->string('title_button_one')->nullable();
            $table->string('link_button_one')->nullable();
            $table->enum('target_link_button_one', ['_self', '_blank'])->default('_self');
            $table->string('title_button_two')->nullable();
            $table->string('link_button_two')->nullable();
            $table->enum('target_link_button_two', ['_self', '_blank'])->default('_self');
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
        Schema::dropIfExists('sche02_schedules');
    }
}
