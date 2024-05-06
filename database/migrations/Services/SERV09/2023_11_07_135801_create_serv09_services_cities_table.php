<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ09ServicesCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv09_services_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->nullable()->constrained('serv09_services_states')->onDelete('cascade');
            $table->string('city')->nullable();
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
        Schema::dropIfExists('serv09_services_cities');
    }
}
