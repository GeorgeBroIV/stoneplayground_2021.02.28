<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Triviaslugname;

class Triviacategory extends Model
{
    use HasFactory;
    public $table = "triviacategory";
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'triviaslugname_id',
		'slugvalue',
	];
	
	public function triviaslugname()
	{
		return $this->belongsTo(Triviaslugname::class);
	}
}
