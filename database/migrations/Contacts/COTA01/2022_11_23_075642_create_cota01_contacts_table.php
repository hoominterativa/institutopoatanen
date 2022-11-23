<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCota01ContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cota01_contacts', function (Blueprint $table) {
            $table->id();

            $table->string('title_banner');
            $table->text('description_banner');
            $table->string('path_image_banner');

            $table->string('title_section');
            $table->text('description_section');

            $table->string('title_form');
            $table->text('description_form');

            $table->string('title_form');
            $table->text('description_form');

            $table->string('path_image_section_topic');

            $table->json('inputs_form');

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
        Schema::dropIfExists('cota01_contacts');
    }
}
