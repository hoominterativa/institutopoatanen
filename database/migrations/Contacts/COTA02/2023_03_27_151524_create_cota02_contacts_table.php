<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCota02ContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cota02_contacts', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable();
            $table->string('title_page')->nullable();

            $table->integer('compliance_id')->nullable();

            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_banner_desktop')->nullable();
            $table->string('path_image_banner_mobile')->nullable();
            $table->string('background_color_banner')->nullable();

            $table->string('path_image_topic_desktop')->nullable();
            $table->string('path_image_topic_mobile')->nullable();
            $table->string('background_color_topic')->nullable();

            $table->string('title_form')->nullable();
            $table->text('description_form')->nullable();
            $table->string('path_image_form_desktop')->nullable();
            $table->string('path_image_form_mobile')->nullable();
            $table->string('background_color_form')->nullable();
            $table->string('title_button_form')->nullable();
            
            $table->text('inputs_form')->nullable();
            $table->string('email_form')->nullable();

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
        Schema::dropIfExists('cota02_contacts');
    }
}
