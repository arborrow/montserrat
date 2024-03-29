<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'location_id' => function () {
                return \App\Models\Location::factory()->create()->id;
            },
            'floor' => $this->faker->numberBetween($min = 1, $max = 2),
            'name' => $this->faker->lastName().' Suite',
            'description' => $this->faker->catchPhrase(),
            'notes' => $this->faker->sentence(),
            'access' => $this->faker->word(),
            'type' => $this->faker->word(),
            'occupancy' => $this->faker->randomDigitNotNull(),
            'status' => $this->faker->word(),
        ];
    }
}
