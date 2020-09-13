<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\LocationType;
use Illuminate\Database\Eloquent\Factories\Factory;

// using Montserrat's number in case of Twilio checks with a random extension

class PhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Phone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'contact_id' => function () {
            return Contact::factory()->create()->id;
        },
        'location_type_id' => function () {
            return LocationType::factory()->create()->id;
        },
        'phone' => '9403216020,'.$this->faker->numberBetween(111, 999),
        'phone_type' => $this->faker->randomElement(['Phone', 'Fax', 'Mobile']),
    ];
    }
}
