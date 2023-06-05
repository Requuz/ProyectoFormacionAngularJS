<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarshipPilot extends Model
{
    protected $fillable = [
        'starship_id',
        'pilot_id'
    ];

    use HasFactory;

    protected $table = 'starship_pilot';

    public function starship()
    {
        return $this->belongsTo(Starship::class, 'starship_pilot');
    }

    public function pilot()
    {
        return $this->belongsTo(Pilot::class, 'starship_pilot');
    }

}
