<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AddressFactory extends Factory
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
            'location_type_id' => $this->faker->randomElement([1, 2, 4]),
            'is_primary' => $this->faker->boolean(),
            'is_billing' => $this->faker->boolean(),
            'street_address' => $this->faker->streetAddress(),
            'street_number' => $this->faker->randomNumber(),
            'street_number_suffix' => $this->faker->word(),
            'street_number_predirectional' => $this->faker->word(),
            'street_name' => $this->faker->streetName(),
            'street_type' => $this->faker->streetSuffix(),
            'street_number_postdirectional' => $this->faker->word(),
            'street_unit' => $this->faker->secondaryAddress(),
            'supplemental_address_1' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'county_id' => $this->faker->randomNumber(),
            'state_province_id' => $this->faker->numberBetween(1000, 1050),
            'postal_code_suffix' => $this->faker->numberBetween(1000, 9999),
            'postal_code' => $this->faker->postcode(),
            'country_id' => '1228',
            'timezone' => $this->faker->word(),
            'name' => $this->faker->name(),
            'master_id' => $this->faker->randomNumber(),
            'remember_token' => Str::random(10),
        ];
    }
}
