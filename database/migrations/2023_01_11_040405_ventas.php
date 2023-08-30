<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ventas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('id');
            $table->string('code',10)->unique();
            $table->double('total',9,2);
            $table->integer('amount');
            $table->tinyInteger('tax');
            $table->tinyInteger('transaction');
            //$table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreignId('client');
            $table->foreign('client')->references('id')->on('clients');
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
        Schema::dropIfExists('sales');
    }
}
