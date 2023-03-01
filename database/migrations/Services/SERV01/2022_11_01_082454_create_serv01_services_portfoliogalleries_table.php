<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ01ServicesPortfoliogalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv01_services_portfoliogalleries', function (Blueprint $table) {
            $table->id();
            $table->string('path_image')->nullable();
            $table->string('legend')->nullable();
            $table->integer('sorting')->default(0);
            $table->foreignId('portfolio_id')->constrained('serv01_services_portfolios');
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
        Schema::dropIfExists('serv01_services_portfoliogalleries');
    }
}
