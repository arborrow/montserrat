<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'iso_code' => $this->faker->word(),
            'country_code' => $this->faker->word(),
            'address_format_id' => $this->faker->randomNumber(),
            'idd_prefix' => $this->faker->word(),
            'ndd_prefix' => $this->faker->word(),
            'region_id' => $this->faker->randomNumber(),
            'is_province_abbreviated' => $this->faker->boolean(),
            'remember_token' => Str::random(10),
        ];
    }
}
