<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComp01CompliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp01_compliances', function (Blueprint $table) {
            $table->id();
            $table->string('title_page')->nullable();
            $table->string('slug')->nullable();
            $table->string('title_banner')->nullable();
            $table->string('path_image_banner')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('path_image_icon')->nullable();
            $table->longText('text')->nullable();
            $table->integer('active')->nullable();
            $table->integer('show_footer')->default(0);
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
        Schema::dropIfExists('comp01_compliances');
    }
}
