<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Compras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->id('id');
            $table->string('code',10)->unique();
            $table->double('total',9,2);
            $table->integer('amount');
            $table->tinyInteger('tax');
            $table->tinyInteger('transaction');
            $table->timestamps();
            $table->foreignId('supplier');
            $table->foreign('supplier')->references('id')->on('suppliers');
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
        Schema::dropIfExists('buys');
    }
}
