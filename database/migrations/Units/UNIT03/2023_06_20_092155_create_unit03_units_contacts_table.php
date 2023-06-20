<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnit03UnitsContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit03_units_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit03_units');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('title_button')->nullable();
            $table->text('inputs_form')->nullable();
            $table->string('email_form')->nullable();
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('unit03_units_contacts');
    }
}
