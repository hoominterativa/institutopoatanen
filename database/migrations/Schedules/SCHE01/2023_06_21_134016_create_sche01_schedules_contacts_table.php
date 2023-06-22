<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSche01SchedulesContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sche01_schedules_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('compliance_id')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('sche01_schedules_contacts');
    }
}
