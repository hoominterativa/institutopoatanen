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
            $table->foreignId('category_id')->constrained('cota04_contacts_categories')->nullable();
            $table->string('slug')->nullable();
            $table->integer('compliance_id')->nullable();
            //Banner
            $table->string('title_banner')->nullable();
            $table->string('subtitle_banner')->nullable();
            $table->string('path_image_banner_desktop')->nullable();
            $table->string('path_image_banner_mobile')->nullable();
            $table->string('background_color_banner')->nullable();
            //Content
            $table->string('title_content')->nullable();
            $table->string('subtitle_content')->nullable();
            $table->text('description_content')->nullable();
            $table->string('path_image_content')->nullable();
            //Form
            $table->string('title_form')->nullable();
            $table->text('description_form')->nullable();
            $table->string('title_button_form')->nullable();
            $table->text('inputs_form')->nullable();
            $table->string('email_form')->nullable();
            $table->string('title_compliance')->nullable();
            $table->string('subtitle_compliance')->nullable();
            $table->string('path_image_compliance_icon')->nullable();

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
        Schema::dropIfExists('cota04_contacts');
    }
}
