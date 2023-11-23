<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCota04ContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cota04_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->integer('compliance_id')->nullable();
            $table->string('title_page')->nullable();
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_banner_desktop')->nullable();
            $table->string('path_image_banner_mobile')->nullable();
            $table->string('background_color_banner')->nullable();
            $table->string('title_content')->nullable();
            $table->string('subtitle_content')->nullable();
            $table->text('description_content')->nullable();
            $table->string('path_image_content')->nullable();
            $table->string('title_button_form')->nullable();
            $table->string('email_form')->nullable();
            $table->string('title_compliance')->nullable();
            $table->string('subtitle_compliance')->nullable();
            $table->integer('active')->default(0);
            $table->integer('sorting')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cota04_contacts');
    }
}
