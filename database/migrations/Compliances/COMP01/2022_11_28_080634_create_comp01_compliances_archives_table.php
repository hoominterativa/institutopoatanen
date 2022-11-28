<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComp01CompliancesArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp01_compliances_archives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compliance_id')->constrained('comp01_compliances')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('path_archive')->nullable();
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
        Schema::dropIfExists('comp01_compliances_archives');
    }
}
