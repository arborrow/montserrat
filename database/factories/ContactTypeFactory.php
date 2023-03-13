<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContactTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'label' => $this->faker->word(),
            'description' => $this->faker->text(),
            'image_URL' => $this->faker->word(),
            'parent_id' => $this->faker->randomNumber(),
            'is_active' => $this->faker->boolean(),
            'is_reserved' => $this->faker->boolean(),
            'status' => $this->faker->word(),
            'remember_token' => Str::random(10),
        ];
    }
}
