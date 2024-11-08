<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort06PortfoliosSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port06_portfolios_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title_section')->nullable();
            $table->string('subtitle_section')->nullable();
            $table->text('paragraph_section')->nullable();
            //
            $table->string('title_page')->nullable();
            $table->text('subtitle_page')->nullable();
            $table->text('path_image_desktop_banner')->nullable();
            $table->text('path_image_mobile_banner')->nullable();
            //
            $table->string('title_button')->nullable();
            $table->text('link_button')->nullable();
            $table->enum('target_link_button', ['_self', '_blank'])->default('_self');
            $table->integer('active_section')->default(0);
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
        Schema::dropIfExists('port06_portfolios_sections');
    }
}
