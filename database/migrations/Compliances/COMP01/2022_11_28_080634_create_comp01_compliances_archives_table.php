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
            $table->foreignId('section_id')->constrained('comp01_compliances_sections')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->enum('link_target', ['_self', '_blank'])->default('_self');
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
