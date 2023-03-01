<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ01ServicesPortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv01_services_portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);
            $table->string('path_image')->nullable();
            $table->foreignId('service_id')->constrained('serv01_services');
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
        Schema::dropIfExists('serv01_services_portfolios');
    }
}
