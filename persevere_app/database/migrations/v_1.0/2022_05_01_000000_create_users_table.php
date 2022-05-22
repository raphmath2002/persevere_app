<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('firstname');
            $table->date('birth_date');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone');
            $table->string('postal_code');
            $table->string('postal_address');
            $table->string('city');
            $table->string('country');
            $table->text('storage_path');
            $table->string('auth_level');
            $table->string('api_token')->nullable();
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
        Schema::dropIfExists('users');
    }
};
