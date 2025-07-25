<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort06PortfoliosGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port06_portfolios_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('port06_portfolios');
            $table->string('path_image')->nullable();
            $table->text('link_video')->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('port06_portfolios_galleries');
    }
}
