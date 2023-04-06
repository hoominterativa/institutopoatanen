<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCont10ContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cont10_contents', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('title')->nullable();
            $table->string('locale')->nullable();
            $table->string('link')->nullable();
            $table->enum('link_target', ['_self', '_blank'])->default('_self');
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
        Schema::dropIfExists('cont10_contents');
    }
}
