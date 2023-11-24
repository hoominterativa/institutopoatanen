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
            $table->foreignId('contentPage_id')->constrained('copa01_contentpages');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->enum('link_target',['_self', '_blank'])->default('_self');
            $table->string('path_archive')->nullable();
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
        Schema::dropIfExists('copa01_contentpages_sectionarchives');
    }
}
