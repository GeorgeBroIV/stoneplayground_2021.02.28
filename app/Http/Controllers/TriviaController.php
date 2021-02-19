<?php

namespace App\Http\Controllers;

use App\Models\Triviacategory;
use App\Models\Triviadifficulty;
use App\Models\Triviaslugname;
use App\Models\Triviatype;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Trivia;

class TriviaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    // Trivia Categories
	    $triviaCategories = new Collection();
	    $categories = Triviacategory::with('triviaslugname')->get();
	    foreach($categories as $category) {
		    $triviaCategories[$category->slugvalue] = $category->name;
	    }
	
	    // Trivia Difficulty
	    $triviaDifficulties = new Collection();
	    $difficulties = Triviadifficulty::with('triviaslugname')->get();
	    foreach($difficulties as $difficulty) {
		    $triviaDifficulties[$difficulty->slugvalue] = $difficulty->name;
	    }
	
	    // Trivia Type
	    $triviaTypes = Triviatype::get()->pluck('name', 'slugvalue');
	
	    // Return
	    return Inertia::render('Trivia', compact('triviaCategories', 'triviaDifficulties', 'triviaTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trivia  $trivia
     * @return \Illuminate\Http\Response
     */
    public function show(Trivia $trivia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trivia  $trivia
     * @return \Illuminate\Http\Response
     */
    public function edit(Trivia $trivia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trivia  $trivia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trivia $trivia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trivia  $trivia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trivia $trivia)
    {
        //
    }
}
