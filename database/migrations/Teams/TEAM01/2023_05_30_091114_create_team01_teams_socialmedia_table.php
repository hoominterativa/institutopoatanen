<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeam01TeamsSocialmediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team01_teams_socialmedia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('team01_teams');
            $table->string('link')->nullable();
            $table->enum('target_link', ['_self', '_blank'])->default('_self');
            $table->string('path_image_icon')->nullable();
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
        Schema::dropIfExists('team01_teams_socialmedia');
    }
}
