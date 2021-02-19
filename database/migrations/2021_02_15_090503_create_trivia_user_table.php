<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriviaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trivia_user', function (Blueprint $table) {
        	$table->id();
	        $table->foreignId('trivia_id');
	        $table->foreignId('user_id');
	        $table->foreignId('triviacategory_id');
	        $table->foreignId('triviadifficulty_id');
	        $table->integer('questions_total');
	        $table->integer('questions_correct');
	        $table->foreignId('created_by')->nullable();
	        $table->timestamps();
	
	        $table->foreign('trivia_id')->references('id')->on('trivia');
	        $table->foreign('triviacategory_id')->references('id')->on('triviacategory');
	        $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trivia_user');
    }
}
