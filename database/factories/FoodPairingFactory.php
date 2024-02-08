<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FoodPairingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pairing' => $this->faker->word(),
        ];
    }
}
