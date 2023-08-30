<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('ci',15);
            $table->string('name',50);
            $table->string('lastname',50);
            $table->string('phone',8);
            $table->string('email',50)->nullable();
            $table->string('type',15);
            $table->string('photo',100)->default("users/default_user.jpg");
            $table->string('login',50)->unique();
            $table->string('password',255);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreignId('user');
            $table->foreign('user')->references('id')->on('users');
            $table->foreignId('cash');
            $table->foreign('cash')->references('id')->on('cashes');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
