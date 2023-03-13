<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DonationTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $label = $this->faker->word();
        $value = $this->faker->numberBetween(1000, 2000);

        return [
            'label' => $label,
            'value' => $value,
            'name' => $label,
            'description' => $label.' ('.$value.')',
            'is_active' => $this->faker->boolean(),
        ];
    }
}
