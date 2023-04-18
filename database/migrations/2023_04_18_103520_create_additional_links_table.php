<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_links', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('link')->nullable();
            $table->enum('link_target',['_blank', '_self'])->nullable();
            $table->enum('position',['header', 'footer', 'both'])->nullable();
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
        Schema::dropIfExists('additional_links');
    }
}
