<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_headers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('module')->nullable();
            $table->string('model')->nullable();
            $table->string('page')->nullable();
            $table->string('link')->nullable();
            $table->enum('target_link',['_self','_blank'])->default('_self');
            $table->boolean('dropdown')->nullable();
            $table->string('select_dropdown')->nullable();
            $table->string('condition')->nullable();
            $table->boolean('exists')->nullable();
            $table->integer('limit')->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('setting_headers');
    }
}
