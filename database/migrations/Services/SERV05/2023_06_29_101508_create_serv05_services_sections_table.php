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
            //Topic
            $table->string('title_topic')->nullable();
            $table->string('subtitle_topic')->nullable();
            $table->text('description_topic')->nullable();

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
