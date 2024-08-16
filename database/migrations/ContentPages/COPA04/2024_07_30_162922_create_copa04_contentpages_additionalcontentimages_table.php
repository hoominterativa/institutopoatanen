<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa04ContentpagesAdditionalcontentimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa04_contentpages_additionalcontentimages', function (Blueprint $table) {
            $table->id();
            $table->index('contentpage_id', 'fk_contentpage_dditionalcontentimages_idx');
            $table->foreignId('contentpage_id')->constrained('copa04_contentpages')->name('fk_contentpage_dditionalcontentimages_idx');
            $table->string('link_video')->nullable();
            $table->string('path_image')->nullable();
            $table->boolean('active')->default(0);
            $table->integer('sorting')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('copa04_contentpages_additionalcontentimages');
    }
}
