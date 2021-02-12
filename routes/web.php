<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Inertia Routes are identified in
|	/vendor/laravel/jetstream/routes/inertia.php
| Fortify Routes are identified in
|   /vendor/laravel/fortify/routes/routes.php
| Rules are identified in
|   /vendor/laravel/fortify/src/Rules/Password.php
|
|   AND LOOK IN /vendor/laravel/fortify/src for TONS of other goodies
|   like config, Actions, Contracts, Controllers, Requests, Responses
|
|   AND LOOK IN /vendor/laravel/jetstream for TONS of other goodies
|   like components, actions, contracts, events, controllers, middleware, mail, rules,
|
|   AND LOOK IN /vendor/inertiaja for TONS of other goodies
|   like components, actions, contracts, events, controllers, middleware, mail, rules,
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');