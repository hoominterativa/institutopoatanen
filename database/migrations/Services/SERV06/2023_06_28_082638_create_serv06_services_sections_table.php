<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ06ServicesSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv06_services_sections', function (Blueprint $table) {
            $table->id();
            //Section
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->text('description_section')->nullable();
            $table->string('path_image_section')->nullable();
            $table->integer('active_section')->default(0);
            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->integer('active_banner')->default(0);
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
        Schema::dropIfExists('serv06_services_sections');
    }
}
