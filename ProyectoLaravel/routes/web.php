<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StarshipController;
use App\Http\Controllers\PilotsController;
use App\Http\Controllers\StarshipPilotController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/starships', function () {
    return view('starships');
});

Route::get('/starships', [StarshipController::class, 'index']);

Route::get('/pilots', function () {
    return view('pilots');
});

Route::get('/pilots', [PilotsController::class, 'index']);

Route::get('/starshipPilot', function () {
    return view('starshipPilot');
});

Route::get('/starshipPilot', [StarshipPilotController::class, 'index'])->name('starshipPilot');

Route::post('/pilots/destroyById', [StarshipPilotController::class, 'destroyById'])->name('pilots.destroyById');

Route::post('/destroyById/{id}', 'App\Http\Controllers\StarshipPilotController@destroyById');
Route::post('/linkPilot', 'App\Http\Controllers\StarshipPilotController@linkPilot');

Route::post('/starships/unlinkPilot', 'StarshipController@unlinkPilot')->name('starships.unlinkPilot');

