<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStarshipPilotTable extends Migration
{
    public function up()
    {
        Schema::create('starship_pilot', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('starship_id');
            $table->unsignedBigInteger('pilot_id');
            $table->timestamps();

            //References
            $table->foreign('starship_id')->references('id')->on('starships')->onDelete('cascade');
            $table->foreign('pilot_id')->references('id')->on('pilots')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('starship_pilot');
    }
}
