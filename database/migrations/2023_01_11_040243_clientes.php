<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Clientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('id');
            $table->string('ci',15)->unique();
            $table->string('name',50);
            $table->string('lastname',50);
            $table->string('phone',10)->nullable();
            $table->string('email',50)->nullable();
            $table->string('address',100)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
