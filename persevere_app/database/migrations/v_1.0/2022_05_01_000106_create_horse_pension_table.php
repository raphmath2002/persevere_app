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
        Schema::create('horse_pension', function (Blueprint $table) {
            $table->id();
            $table->foreignId("horse_id")->constrained()->onDelete("cascade"); 
            $table->foreignId("pension_id")->constrained()->onDelete("cascade"); 
            $table->timestamp('subscribe_date')->default(\DB::raw('UTC_TIMESTAMP'));
            $table->timestamp('unsubscribe_date')->default(\DB::raw('UTC_TIMESTAMP'))->nullable();
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
        Schema::dropIfExists('horse_pension');
    }
};
