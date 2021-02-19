<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Trivia extends Model
{
	use HasFactory;
	public $table = "trivia";
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'opentdb_token',
	];
	
	public function users()
	{
		return $this->belongsToMany(User::class);
	}
}
