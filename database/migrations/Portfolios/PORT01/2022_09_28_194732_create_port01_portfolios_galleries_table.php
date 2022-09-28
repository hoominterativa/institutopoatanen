<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort01PortfoliosGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port01_portfolios_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('path_image')->nullable();
            $table->foreignId('portfolio_id')->constrained('port01_portfolios');
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
        Schema::dropIfExists('port01_portfolios_galleries');
    }
}
