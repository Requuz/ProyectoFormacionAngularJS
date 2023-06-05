<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStarshipsTable extends Migration
{
    public function up()
    {
        Schema::create('starships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model');
            $table->string('manufacturer');
            $table->string('cost_in_credits');
            $table->string('length');
            $table->string('max_atmosphering_speed');
            $table->string('crew');
            $table->string('passengers');
            $table->string('cargo_capacity');
            $table->string('consumables');
            $table->string('hyperdrive_rating');
            $table->string('MGLT');
            $table->string('starship_class');
            $table->string('created');
            $table->string('edited');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('starships');
    }
}

