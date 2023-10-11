<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCota04ContactsFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cota04_contacts_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('cota04_contacts_categories');
            $table->foreignId('section_id')->constrained('cota04_contacts_sections');
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
        Schema::dropIfExists('cota04_contacts_forms');
    }
}
