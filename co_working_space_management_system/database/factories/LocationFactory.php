<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'address' => $this->faker->address,
            'contact_number' => $this->faker->randomNumber(),
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
