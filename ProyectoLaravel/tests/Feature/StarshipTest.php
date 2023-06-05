<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use App\Models\Starship;
use App\Models\Pilot;
use Database\Factories\PilotFactory;
use Illuminate\Support\Facades\Log;


class StarshipTest extends TestCase
{
     // esto garantiza que no se realicen cambios en la base de datos
    use DatabaseTransactions;

    /** @test */
    public function una_nave_puede_ser_creada_y_devuelta()
    {
        $starship = Starship::create([
            'name' => 'Millennium Falcon',
            'model' => 'YT-1300 light freighter',
            'manufacturer' => 'Corellian Engineering Corporation',
            'cost_in_credits' => '100000',
            'length' => '34.37',
            'max_atmosphering_speed' => '1050',
            'crew' => '4',
            'passengers' => '6',
            'cargo_capacity' => '100000',
            'consumables' => '2 months',
            'hyperdrive_rating' => '0.5',
            'MGLT' => '75',
            'starship_class' => 'Light freighter',
            'created' => now(),
            'edited' => now(),
        ]);

        $this->assertNotNull($starship);
        $this->assertEquals('Millennium Falcon', $starship->name);
    }

    /** @test */
public function una_nave_no_puede_ser_creada_con_datos_invalidos()
{
    // Crear un piloto para la prueba
    $pilot = Pilot::factory()->create();

    // Intentar crear una nave con datos inválidos
    $starshipData = [
        'name' => 'Millennium Falcon',
        'model' => '', // Modelo inválido
        'manufacturer' => 'Corellian Engineering Corporation',
        'cost_in_credits' => '100000',
        'length' => '34.37',
        'max_atmosphering_speed' => '1050',
        'crew' => '4',
        'passengers' => '6',
        'cargo_capacity' => 'no es un número', // Capacidad de carga inválida
        'consumables' => '2 months',
        'hyperdrive_rating' => '0.5',
        'MGLT' => '75',
        'starship_class' => 'Light freighter',
        'created' => now(),
        'edited' => now(),
    ];

    $validator = Validator::make($starshipData, [
        'name' => 'required',
        'model' => 'required',
        'cargo_capacity' => 'numeric',
    ]);

    // No debemos crear la nave si la validación falla
    $this->assertTrue($validator->fails());

    // Verificar que se produzcan errores de validación específicos
    $this->assertEquals(['model', 'cargo_capacity'], array_keys($validator->errors()->toArray()));

    // Si la validación no falla, intentamos crear la nave, lo cual no debería suceder en este caso
    if (!$validator->fails()) {
        $starship = Starship::create($starshipData);

        // Verificar que la nave no se guardó
        $this->assertEquals(0, Starship::count());

        // Eliminar la starship creada
        if ($starship->exists) {
            $starship->delete();
        }
    }
}

}
