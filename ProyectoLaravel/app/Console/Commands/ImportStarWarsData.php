<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use App\Models\Starship;
use App\Models\Pilot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportStarWarsData extends Command
{
    protected $signature = 'import:starwars-data';

    protected $description = 'Importar naves y pilotos de SWAPI';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $this->info('Importando datos de SWAPI...');

        //Reiniciar el contenido de la base de datos
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('starship_pilot')->truncate();
        DB::table('starships')->truncate();
        DB::table('pilots')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

         //url para importar datos de los pilotos
        $peopleUrl = 'https://swapi.dev/api/people/';
        $this->importPilots($peopleUrl);

        //url para importar datos de las naves
        $starshipsUrl = 'https://swapi.dev/api/starships/';
        $this->importStarships($starshipsUrl);

        $this->info('¡Datos importados correctamente!');
        $this->info('Importadas ' . Pilot::count() . ' personas de SWAPI.');
        $this->info('Importadas ' . Starship::count() . ' naves de SWAPI.');
    }

private function importStarships($url, $page = 1, $retries = 3)
{
    $this->info("Importando naves - Página $page");
    $response = Http::get($url);

    if ($response->successful()) {
        $data = $response->json();

        foreach ($data['results'] as $starshipData) {
            $starship = new Starship();
            $starship->fill([
                'name' => $starshipData['name'],
                'model' => $starshipData['model'],
                'manufacturer' => $starshipData['manufacturer'],
                'cost_in_credits' => strcmp($starshipData['cost_in_credits'], 'unknown') == 0 ? 100000 : $starshipData['cost_in_credits'],
                'length' => $starshipData['length'],
                'max_atmosphering_speed' => $starshipData['max_atmosphering_speed'],
                'crew' => $starshipData['crew'],
                'passengers' => $starshipData['passengers'],
                'cargo_capacity' => $starshipData['cargo_capacity'],
                'consumables' => $starshipData['consumables'],
                'hyperdrive_rating' => $starshipData['hyperdrive_rating'],
                'MGLT' => $starshipData['MGLT'],
                'starship_class' => $starshipData['starship_class'],
                'created' => $starshipData['created'],
                'edited' => $starshipData['edited'],
            ]);
            $starship->save();

            //Vincular pilotos a naves
            foreach ($starshipData['pilots'] as $pilotUrl) {
                $pilotId = $this->getIdFromUrl($pilotUrl, 'people');
                $pilot = Pilot::find($pilotId);
                if ($pilot) {
                    $starship->pilots()->attach($pilot);
                }
            }
        }

        if ($data['next']) {
            sleep(1); // Espera 1 segundo antes de realizar la siguiente solicitud
            $this->importStarships($data['next'], $page + 1);
        }
        } else {
            if ($retries > 0) {
                $this->error("Error al importar naves - Página $page - Código de estado: {$response->status()} - Reintentando...");
                sleep(5); // Espera 5 segundos antes de reintentar
                $this->importStarships($url, $page, $retries - 1);
            }
        }
}


    private function importPilots($url, $page = 1, $retries = 3){

        $this->info("Importando people - Página $page");
        $response = Http::get($url);

        if ($response->successful()) {
        $data = $response->json();

        foreach ($data['results'] as $pilotData) {

            //Obtener el nombre del 'homeworld'
            $homeworldResponse = Http::get($pilotData['homeworld']);
            $homeworldName = $homeworldResponse->successful() ? $homeworldResponse->json()['name'] : 'Desconocido';
            $pilot = new Pilot();

            $pilot->fill([
                'name' => $pilotData['name'],
                'height' => $pilotData['height'],
                'mass' => $pilotData['mass'],
                'hair_color' => $pilotData['hair_color'],
                'skin_color' => $pilotData['skin_color'],
                'eye_color' => $pilotData['eye_color'],
                'birth_year' => $pilotData['birth_year'],
                'gender' => $pilotData['gender'],
                'homeworld' => $homeworldName,
                'created' => $pilotData['created'],
                'edited' => $pilotData['edited'],
            ]);

            $pilot->save();
        }

        if ($data['next']) {
            sleep(1); // Espera 1 segundo antes de realizar la siguiente solicitud
            $this->importPilots($data['next'], $page + 1);
        }
    } else {
        if ($retries > 0) {
            $this->error("Error al importar people - Página $page - Código de estado: {$response->status()} - Reintentando...");
            sleep(5); // Espera 5 segundos antes de reintentar
            $this->importPilots($url, $page, $retries - 1);
        }
    }
    }
    //Obtener el id de piloto asociado a cada nave
    private function getIdFromUrl($url, $resource){
        $pattern = '/https:\/\/swapi.dev\/api\/' . $resource . '\/(\d+)\//';
        preg_match($pattern, $url, $matches);
        return isset($matches
        [1]) ? (int)$matches[1] : null;
    }
}

