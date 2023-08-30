<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mensajes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('to');
            $table->foreign('to')->references('id')->on('users');
            $table->foreignId('from');
            $table->foreign('from')->references('id')->on('users');
            $table->string('subject',100)->nullable();
            $table->string('message',255)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('type');
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
        Schema::dropIfExists('messages');
    }
}
