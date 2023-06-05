<?php

use App\Models\Starship;
use App\Models\Pilot;
use App\Models\StarshipPilot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PilotsController;
use App\Http\Controllers\Api\StarshipPilotController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/starships', function () {
    return Starship::all();
});
Route::get('/pilots', function () {
    return Pilot::all();
});
Route::get('/starshipPilot', function () {
    return StarshipPilot::all();
});

Route::post('/destroyById/{id}', 'App\Http\Controllers\StarshipPilotController@destroyById');
Route::post('/linkPilot/{pilot_id}/{starship_id}', 'App\Http\Controllers\StarshipPilotController@linkPilot');
Route::post('/unlinkPilot/{pilot_id}/{starship_id}', 'App\Http\Controllers\StarshipPilotController@unlinkPilot');


