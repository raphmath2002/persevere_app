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
        Schema::create('exception_facility', function (Blueprint $table) {
            $table->id();
            $table->foreignId("exception_id")->constrained()->onDelete("cascade"); 
            $table->foreignId("facility_id")->constrained()->onDelete("cascade"); 
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
        Schema::dropIfExists('exception_facility');
    }
};
