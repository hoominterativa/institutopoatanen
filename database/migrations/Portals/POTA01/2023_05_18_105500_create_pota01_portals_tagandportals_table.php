<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePota01PortalsTagandportalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pota01_portals_tagandportals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('pota01_portals');
            $table->foreignId('tag_id')->constrained('pota01_portals_tags');
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
        Schema::dropIfExists('pota01_portals_tagandportals');
    }
}
