<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriviacategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triviacategory', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
	        $table->foreignId('triviaslugname_id');
	        $table->smallInteger('slugvalue')->unique();
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
        Schema::dropIfExists('triviacategory');
    }
}
