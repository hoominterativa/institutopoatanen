<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeed05FeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed05_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('testimony')->nullable();
            $table->integer('classification')->nullable();
            $table->string('path_image')->nullable();
            $table->integer('sorting')->default(0);
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('feed05_feedbacks');
    }
}
