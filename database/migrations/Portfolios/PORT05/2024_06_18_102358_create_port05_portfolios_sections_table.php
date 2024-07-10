<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort05PortfoliosSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port05_portfolios_sections', function (Blueprint $table) {
            $table->id();
            //Section home
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->boolean('active_section')->default(0);
            //Banner page
            $table->string('title_banner')->nullable();
            $table->string('title_page')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->boolean('active_banner')->default(0);
            //General settings
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
        Schema::dropIfExists('port05_portfolios_sections');
    }
}
