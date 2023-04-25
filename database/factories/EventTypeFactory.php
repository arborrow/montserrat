<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'value' => $this->faker->word(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTime('now'),
            'updated_at' => $this->faker->dateTime('now'),
            'remember_token' => Str::random(10),
        ];
    }
}
