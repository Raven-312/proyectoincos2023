<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->string('code',13)->unique();
            $table->string('name',50);
            $table->string('brand',50);
            $table->string('model',50)->nullable();
            $table->string('unit',50);
            $table->double('price',9,2);
            $table->string('photo',255)->default("products/default_product.jpg");
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreignId('category');
            $table->foreign('category')->references('id')->on('categories');
            $table->bigInteger('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
