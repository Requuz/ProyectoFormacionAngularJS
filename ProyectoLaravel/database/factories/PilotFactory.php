<?php

namespace Database\Factories;

use App\Models\Pilot;
use Illuminate\Database\Eloquent\Factories\Factory;

class PilotFactory extends Factory
{

    protected $model = Pilot::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'height' => $this->faker->randomFloat(2, 150, 200),
            'mass' => $this->faker->randomFloat(2, 50, 100),
            'hair_color' => $this->faker->colorName,
            'skin_color' => $this->faker->colorName,
            'eye_color' => $this->faker->colorName,
            'birth_year' => $this->faker->year,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'homeworld' => $this->faker->country,
            'created' => now(),
            'edited' => now(),
        ];
    }
}
