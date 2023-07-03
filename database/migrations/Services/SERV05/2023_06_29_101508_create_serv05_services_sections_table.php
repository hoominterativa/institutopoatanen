<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ05ServicesSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv05_services_sections', function (Blueprint $table) {
            $table->id();
            // Home
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            // Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            //About
            $table->string('title_about')->nullable();
            $table->string('subtitle_about')->nullable();
            $table->text('description_about')->nullable();
            //Topic
            $table->string('title_topic')->nullable();
            $table->string('subtitle_topic')->nullable();
            $table->string('title_topic_button')->nullable();
            $table->text('link_topic')->nullable();
            $table->enum('target_link', ['_self', '_blank'])->default('_self');

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
        Schema::dropIfExists('serv05_services_sections');
    }
}
