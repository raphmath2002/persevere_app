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
            $table->date('birth_date');
            $table->string('sire_code');
            $table->string('ueln_code');
            $table->string('birth_country');
            $table->string('sex');
            $table->string('storage_path');
            $table->foreignId("pension_id")->unsigned()->nullable()->onDelete('set null');
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
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
