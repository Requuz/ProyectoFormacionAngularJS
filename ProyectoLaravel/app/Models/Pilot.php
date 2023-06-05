<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pilot extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'height',
        'mass',
        'hair_color',
        'skin_color',
        'eye_color',
        'birth_year',
        'gender',
        'homeworld',
        'created',
        'edited',
    ];

    public function starships()
    {
        return $this->belongsToMany(Starship::class, 'starship_pilot');
    }
}
