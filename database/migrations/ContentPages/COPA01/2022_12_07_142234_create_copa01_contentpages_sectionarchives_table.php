<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa01ContentpagesSectionarchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa01_contentpages_sectionarchives', function (Blueprint $table) {
            $table->id();
            $table->string('section_id')->nullable();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->enum('link_target',['_self', '_blankl'])->default('_self');
            $table->string('path_archive')->nullable();
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
        Schema::dropIfExists('copa01_contentpages_sectionarchives');
    }
}
