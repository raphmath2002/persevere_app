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
        Schema::create('appointment_horse', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('status');
            $table->string('price')->nullable();
            $table->timestamp('start_date')->default(\DB::raw('UTC_TIMESTAMP'));
            $table->timestamp('end_date')->default(\DB::raw('UTC_TIMESTAMP'));
            $table->text('cares')->nullable();
            $table->text('observations')->nullable();
            $table->foreignId("appointment_id")->constrained()->onDelete("cascade"); 
            $table->foreignId("horse_id")->constrained()->onDelete("cascade"); 
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
        Schema::dropIfExists('appointment_horse');
    }
};
