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

            $table->string('title_page')->nullable();
            $table->string('slug')->nullable();

            $table->string('title_banner')->nullable();
            $table->text('description_banner')->nullable();
            $table->string('path_image_banner')->nullable();

            $table->string('title_section')->nullable();
            $table->text('description_section')->nullable();

            $table->string('title_form')->nullable();
            $table->text('description_form')->nullable();
            $table->string('title_button_form')->nullable();

            $table->string('path_image_section_topic')->nullable();

            $table->text('inputs_form')->nullable();

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
        Schema::dropIfExists('cota01_contacts');
    }
}
