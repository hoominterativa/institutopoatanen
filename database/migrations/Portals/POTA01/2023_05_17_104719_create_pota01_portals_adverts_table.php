<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePota01PortalsAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pota01_portals_adverts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('pota01_portals_categories');
            $table->foreignId('blog_id')->nullable()->constrained('pota01_portals');
            $table->string('path_image')->nullable();
            $table->text('adsense')->nullable();
            $table->text('link')->nullable();
            $table->enum('link_target', ['_self', '_blank'])->default('_self');
            $table->enum('position', [
                'homeBottomPodcast',
                'bottomLatestNews',
                'category',
                'categoryInnerBeginPage',
                'categoryInnerEndPage',
                'blogInner',
                'podcastBeforeArticle',
                'podcastAfterArticle'
            ])->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
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
        Schema::dropIfExists('pota01_portals_adverts');
    }
}
