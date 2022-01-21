<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('u_id');
            $table->string('firstname', 255);
            $table->string('lastname', 255);
            $table->string('mobile', 10)->unique();
            $table->string('email', 255)->unique();
            $table->string('age', 3);
            $table->enum('gender', ['m', 'f', 'o']);
            $table->string('city', 255);
            $table->string('password', 255);
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
