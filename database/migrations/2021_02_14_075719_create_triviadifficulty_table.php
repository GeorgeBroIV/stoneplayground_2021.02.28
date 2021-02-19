<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriviadifficultyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triviadifficulty', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
	        $table->foreignId('triviaslugname_id');
	        $table->string('slugvalue')->unique();
            $table->timestamps();
	        $table->foreign('triviaslugname_id')->references('id')->on('triviaslugname')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('triviadifficulty');
    }
}
