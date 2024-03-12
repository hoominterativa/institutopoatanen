<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCota05ContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cota05_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('title_page')->nullable();
            $table->integer('compliance_id')->nullable();
            $table->integer('active')->default(0);

            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_desktop_banner')->nullable();
            $table->string('path_image_mobile_banner')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->integer('active_banner')->default(0);

            $table->string('title_form')->nullable();
            $table->text('description_form')->nullable();
            $table->string('path_image_icon_form')->nullable();
            $table->integer('active_form')->default(0);

            $table->text('inputs_form')->nullable();
            $table->text('inputs_assessments')->nullable();
            $table->string('title_button_form')->nullable();
            $table->string('email_form')->nullable();

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
        Schema::dropIfExists('cota05_contacts');
    }
}
