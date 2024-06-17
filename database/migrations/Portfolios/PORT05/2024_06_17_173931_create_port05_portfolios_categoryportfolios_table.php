<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort05PortfoliosCategoryportfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port05_portfolios_categoryportfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('port05_portfolios')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('port05_portfolios_categories')->onDelete('cascade');
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
        Schema::dropIfExists('port05_portfolios_categoryportfolios');
    }
}
