<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_form', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('page')->nullable();
            $table->string('session')->nullable();
            $table->string('position')->nullable();
            $table->string('model')->nullable();
            $table->string('section_title')->nullable();
            $table->string('description')->nullable();
            $table->string('path_image')->nullable();
            $table->json('social_id')->nullable();
            $table->json('inputs')->nullable();
            $table->text('external_structure')->nullable();
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
        Schema::dropIfExists('contact_form');
    }
}
