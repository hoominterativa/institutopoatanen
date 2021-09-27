<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_themes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('color_scheme_mode');
            $table->string('leftsidebar_color');
            $table->string('leftsidebar_size');
            $table->string('topbar_color');
            $table->timestamps();

            $table->index(["user_id"], 'fk_setting_themes_users1_foreign');

            $table->foreign('user_id', 'fk_setting_themes_users1_foreign')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_themes');
    }
}
