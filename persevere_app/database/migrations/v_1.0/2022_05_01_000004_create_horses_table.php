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
        Schema::create('horses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('size');
            $table->float('weigth');
            $table->timestamp('birth_date');
            $table->string('sire_code');
            $table->string('ueln_code');
            $table->string('birth_country');
            $table->string('avatar_path');
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
        Schema::dropIfExists('horses');
    }
};
