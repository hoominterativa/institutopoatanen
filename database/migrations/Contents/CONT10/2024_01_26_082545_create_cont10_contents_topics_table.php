<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCont10ContentsTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont10_contents_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained('cont10_contents')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('locale')->nullable();
            $table->string('title_button')->nullable();
            $table->string('link_button')->nullable();
            $table->enum('link_target_button', ['_self', '_blank'])->default('_self');
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
        Schema::dropIfExists('cont10_contents_topics');
    }
}
