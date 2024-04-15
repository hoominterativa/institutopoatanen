<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ09ServicesContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv09_services_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('serv09_services')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('serv09_services_contents');
    }
}
