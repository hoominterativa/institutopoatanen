<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopa04ContentpagesTopicitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copa04_contentpages_topicitems', function (Blueprint $table) {
            $table->id();
            $table->index('contentpage_id', 'fk_contentpage_topicitems_idx');
            $table->foreignId('contentpage_id')->constrained('copa04_contentpages')->name('fk_contentpage_topicitems_idx');
            $table->string('title', 191)->nullable();
            $table->text('text', 255)->nullable();
            $table->string('path_image', 191)->nullable();
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('copa04_contentpages_topicitems');
    }
}
