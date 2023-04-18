<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallToActionTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_to_action_titles', function (Blueprint $table) {
            $table->id();
            $table->string('title_header')->nullable();
            $table->string('title_footer')->nullable();
            $table->integer('active_header')->default(1);
            $table->integer('active_footer')->default(1);
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
        Schema::dropIfExists('call_to_action_titles');
    }
}
