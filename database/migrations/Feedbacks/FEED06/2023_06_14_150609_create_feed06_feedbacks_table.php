<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeed06FeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed06_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('testimony')->nullable();
            $table->integer('classification')->default(5);
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
        Schema::dropIfExists('feed06_feedbacks');
    }
}
