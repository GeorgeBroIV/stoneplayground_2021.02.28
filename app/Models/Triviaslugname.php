<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Triviacategory;
use App\Models\Triviadifficulty;
use App\Models\Triviatype;

class Triviaslugname extends Model
{
	
	public $table = "triviaslugname";
	use HasFactory;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
	];
	
	public function triviacategory()
	{
		return $this->hasOne(Triviacategory::class);
	}
	
	public function triviadifficulty()
	{
		return $this->hasOne(Triviadifficulty::class);
	}
}