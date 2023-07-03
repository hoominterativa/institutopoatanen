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
            $table->integer('active')->default(0);

            // Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->integer('active_banner')->default(0);

            //About
            $table->string('title_about')->nullable();
            $table->string('subtitle_about')->nullable();
            $table->text('description_about')->nullable();
            $table->integer('active_about')->default(0);


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
