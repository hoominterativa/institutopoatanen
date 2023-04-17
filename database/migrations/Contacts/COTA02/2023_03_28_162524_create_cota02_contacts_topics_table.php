<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCota02ContactsTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cota02_contacts_topics', function (Blueprint $table) {
            $table->id();
            $table->index('contact_id', 'cota02_contacts_contact_id');
            $table->foreignId('contact_id')->constrained('cota02_contacts');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('path_image_icon')->nullable();
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
        Schema::dropIfExists('cota02_contacts_topics');
    }
}
