<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->lastName().' of '.$this->faker->city();

        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
            'occupancy' => $this->faker->numberBetween(10, 50),
            'notes' => $this->faker->text(100),
            'label' => $name,
            'longitude' => $this->faker->longitude(-93, -103),
            'latitude' => $this->faker->latitude(30, 40),
            'type' => $this->faker->randomElement(config('polanco.locations_type')),
        ];
    }
}
