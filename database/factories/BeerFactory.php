<?php

namespace Database\Factories;

use App\Models\Beer;
use App\Models\FoodPairing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class BeerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'beer_id' => $this->faker->unique()->randomNumber(),
            'name' => $this->faker->word(),
            'tagline' => $this->faker->sentence(),
            'first_brewed' => $this->faker->date('m-Y'),
            'description' => $this->faker->paragraph(),
            'image_url' => $this->faker->imageUrl(),
            'abv' => $this->faker->randomFloat(2, 0, 20),
            'ibu' => $this->faker->randomFloat(2, 0, 100),
            'target_fg' => $this->faker->randomFloat(2, 0, 10),
            'target_og' => $this->faker->randomFloat(2, 0, 10),
            'ebc' => $this->faker->randomFloat(2, 0, 100),
            'srm' => $this->faker->randomFloat(2, 0, 100),
            'ph' => $this->faker->randomFloat(2, 0, 14),
            'attenuation_level' => $this->faker->randomFloat(2, 0, 100),
            'volume' => json_encode(['value' => $this->faker->randomNumber(), 'unit' => 'liters']),
            'boil_volume' => json_encode(['value' => $this->faker->randomNumber(), 'unit' => 'liters']),
            'method' => json_encode(['fermentation' => ['temp' => ['value' => $this->faker->randomNumber(), 'unit' => 'celsius']]]),
            'ingredients' => json_encode(['malt' => [$this->faker->word()], 'hops' => [$this->faker->word()], 'yeast' => $this->faker->word()]),
            'brewers_tips' => $this->faker->sentence(),
            'contributed_by' => $this->faker->name(),
        ];
    }

    public function withFoodPairings()
    {
        return $this->afterCreating(function (Model $beer) {
            /** @var Beer $beer */
            $beer->foodPairings()->saveMany(FoodPairing::factory()->count(3)->make());
        });
    }
}
