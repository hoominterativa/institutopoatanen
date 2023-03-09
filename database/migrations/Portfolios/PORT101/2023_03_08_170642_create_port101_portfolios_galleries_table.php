<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort101PortfoliosGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port101_portfolios_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('path_images')->nullable();
            $table->text('path_videos')->nullable();
            $table->foreignId('portfolio_id')->constrained('port101_portfolios');
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
        Schema::dropIfExists('port101_portfolios_galleries');
    }
}
