<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Starship extends Model
{
    // $fillable es un array que contiene los nombres de las columnas de la tabla 'starships' en la base de datos
    protected $fillable = [
        'name',
        'model',
        'manufacturer',
        'cost_in_credits',
        'length',
        'max_atmosphering_speed',
        'crew', 'passengers',
        'cargo_capacity',
        'consumables',
        'hyperdrive_rating',
        'MGLT',
        'starship_class',
        'pilots',
        'films',
        'created',
        'edited',
    ];

    // esta funcion define una relación de muchos a muchos entre Starship y Pilot usando la tabla 'starship_pilot' como intermediario
    public function pilots()
    {
        return $this->belongsToMany(Pilot::class, 'starship_pilot');
    }

}
