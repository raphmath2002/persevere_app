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
        Schema::create('facility_horse', function (Blueprint $table) {
            $table->id();
            $table->foreignId("facility_id")->constrained()->onDelete("cascade"); 
            $table->foreignId("horse_id")->constrained()->onDelete("cascade"); 
            $table->timestamp('start_date')->default(\DB::raw('UTC_TIMESTAMP'));
            $table->timestamp('end_date')->default(\DB::raw('UTC_TIMESTAMP'));
            $table->string('status');
            $table->text('decline_reason')->nullable();
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
        Schema::dropIfExists('facility_horse');
    }
};
