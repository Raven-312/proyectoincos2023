<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Detalleventas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saledetails', function (Blueprint $table) {
            $table->id('id');
            $table->integer('amount');
            $table->double('price',8,2);
            $table->double('subtotal',8,2);
            $table->string('observation',255)->nullable();
            $table->timestamps();
            $table->foreignId('sale');
            $table->foreign('sale')->references('id')->on('sales');
            $table->foreignId('product');
            $table->foreign('product')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saledetails');
    }
}
