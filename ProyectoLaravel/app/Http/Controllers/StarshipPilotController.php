<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Starship;
use App\Models\Pilot;

class StarshipPilotController extends Controller
{
    public function index()
    {
        // Obtiene todos los pilotos y los ordena por nombre
        $pilots = Pilot::all()->sortBy('name');

        // Obtiene todas las naves y las ordena por nombre
        $starships = Starship::all()->sortBy('name');

        // Obtiene los datos de la relación entre naves y pilotos
        $starship_pilot = DB::table('starship_pilot')
            // Une la tabla de naves a la tabla intermedia por el id de la nave
            ->join('starships', 'starship_pilot.starship_id', '=', 'starships.id')
            // Une la tabla de pilotos a la tabla intermedia por el id del piloto
            ->join('pilots', 'starship_pilot.pilot_id', '=', 'pilots.id')
            // Selecciona los datos que se mostrarán en la vista
            ->select('starship_pilot.id', 'starships.name as starship_name', 'pilots.name as pilot_name', 'starships.cost_in_credits')
            // Obtiene los datos
            ->get()
            // Agrupa los datos por el nombre de la nave
            ->groupBy('starship_name');

        return view('starshipPilot', ['starship_pilot' => $starship_pilot], compact('pilots', 'starships'));
    }

public function destroyById($id)
{
    // Encuentra al piloto por su id
    $pilot = Pilot::find($id);

    // Si no se encuentra al piloto, retorna un mensaje de error
    if (!$pilot) {
        return response()->json(['Mensaje:'=> 'Piloto no encontrado'], 404);
    }else{
        // Desvincula al piloto de todas las naves a las que está asociado
        $pilot->starships()->detach();
        // Elimina al piloto
        $pilot->delete();
    }
    // Devuelve un mensaje de éxito
    return response()->json(['Mensaje:'=> 'Piloto eliminado'], 200);

}

  public function linkPilot($pilot_id, $starship_id)
{
    // Buscar el piloto y la nave en la base de datos usando los valores de los parámetros
    $pilot = Pilot::find($pilot_id);
    $starship = Starship::find($starship_id);

    // Si los dos existen, se verifica si ya están vinculados
    if ($starship && $pilot) {
        // Si ya están vinculados, se muestra un mensaje de error
        if ($starship->pilots()->where('pilot_id', $pilot_id)->exists()) {
            return response()->json(['message' => 'El piloto y la nave ya están vinculados.'], 409);
        } else {
            // Si no están vinculados, se vinculan y se muestra un mensaje de éxito
            $starship->pilots()->attach($pilot);
            return response()->json(['success' => 'Piloto y nave vinculados correctamente']);
        }
    }
    // Si cualquiera de los dos no se encuentra, se muestra un mensaje de error
    return response()->json(['message' => 'Nave o piloto no encontrado.'], 404);
}

      public function unlinkPilot($pilot_id, $starship_id)
{
   //Buscar el piloto y la nave en la base de datos usando los valores de los parametros
    $pilot = Pilot::find($pilot_id);
    $starship = Starship::find($starship_id);

    //Si los dos existen, se desvinculan y se muestra un mensaje de éxito
    if ($starship && $pilot) {
        $starship->pilots()->detach($pilot);
        return response()->json(['success' => 'Piloto y nave desvinculados correctamente']);
    }

    //Si cualquiera de los dos no se encuentra, se muestra un mensaje de error
    return response()->json(['message' => 'Nave o piloto no encontrado.'], 404);
}
}
