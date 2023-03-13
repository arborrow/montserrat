<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// using Montserrat's number in case of Twilio checks with a random extension

class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'contact_id' => function () {
                return \App\Models\Contact::factory()->create()->id;
            },
            'location_type_id' => function () {
                return \App\Models\LocationType::factory()->create()->id;
            },
            'phone' => '9403216020,'.$this->faker->numberBetween(111, 999),
            'phone_type' => $this->faker->randomElement(['Phone', 'Fax', 'Mobile']),
        ];
    }
}
