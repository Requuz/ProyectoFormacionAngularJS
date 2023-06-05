<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Starship;

class StarshipController extends Controller
{
    public function index()
{
    $starships = Starship::all();
    return response()->json($starships);
}
}
