<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ActivityStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'value' => $this->faker->word(),
            'name' => $this->faker->name(),
            'is_active' => $this->faker->boolean(),
            'is_default' => $this->faker->boolean(),
            'weight' => $this->faker->randomNumber(),
            'remember_token' => Str::random(10),
        ];
    }
}
