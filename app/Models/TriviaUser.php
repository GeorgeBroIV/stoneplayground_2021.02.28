<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriviaUser extends Model
{
	use HasFactory;
	public $table = "trivia_user";
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'trivia_id',
		'user_id',
		'triviacategory_id',
		'triviadifficulty_id',
		'questions_total',
		'questions_correct',
	];
}
