<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Movimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id('id');
            $table->double('amount',9,2);
            $table->tinyInteger('type');
            $table->string('description',255);
            $table->timestamps();
            $table->foreignId('cash');
            $table->foreign('cash')->references('id')->on('cashes');
            $table->foreignId('user');
            $table->foreign('user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
