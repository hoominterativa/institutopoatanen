<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingSmtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_smtps', function (Blueprint $table) {
            $table->id();
            $table->string('email_test')->nullable();
            $table->string('host')->nullable();
            $table->integer('port')->nullable();
            $table->string('user')->nullable();
            $table->string('password')->nullable();
            $table->longText('report')->nullable();
            $table->enum('encryption', ['ssl', 'tls'])->default('ssl');
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
        Schema::dropIfExists('setting_smtps');
    }
}
