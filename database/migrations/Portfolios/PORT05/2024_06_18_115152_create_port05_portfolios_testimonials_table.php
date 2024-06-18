<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePort05PortfoliosTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port05_portfolios_testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained('port05_portfolios')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('profession')->nullable();
            $table->text('feedback')->nullable();
            $table->string('path_image')->nullable();
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('port05_portfolios_testimonials');
    }
}
