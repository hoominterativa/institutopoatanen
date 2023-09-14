<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServ08ServicesContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv08_services_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('compliance_id')->nullable();
            $table->string('title')->nullable();
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
        Schema::dropIfExists('serv08_services_contacts');
    }
}
