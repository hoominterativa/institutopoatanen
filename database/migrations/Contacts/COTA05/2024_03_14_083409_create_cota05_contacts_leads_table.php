<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCota05ContactsLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cota05_contacts_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('cota05_contacts');
            $table->string('target_lead')->nullable();
            $table->longText('json')->nullable();
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
        Schema::dropIfExists('cota05_contacts_leads');
    }
}
