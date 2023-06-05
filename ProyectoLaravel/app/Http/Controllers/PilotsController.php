<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pilot;

class PilotsController extends Controller
{
    public function index()
    {
        $pilots = Pilot::all();
        return response()->json($pilots);
    }

}
