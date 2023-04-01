<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmergencyContactFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'contact_id' => function () {
                return \App\Models\Contact::factory()->create()->id;
            },
            'name' => $this->faker->name(),
            'relationship' => $this->faker->word(),
            'phone' => '9403216010,'.$this->faker->numberBetween(111, 999),
            'phone_alternate' => '9403216030,'.$this->faker->numberBetween(111, 999),
            'remember_token' => Str::random(10),
        ];
    }
}
