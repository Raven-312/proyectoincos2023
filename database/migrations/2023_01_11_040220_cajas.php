<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cajas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashes', function (Blueprint $table) {
            $table->id('id');
            $table->string('code',10)->unique();
            $table->string('alias',50)->nullable();
            $table->double('cash', 9, 2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
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
        Schema::dropIfExists('cashes');
    }
}
