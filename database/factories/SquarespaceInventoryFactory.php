<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SquarespaceInventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word().' '.$this->faker->word(),
            'custom_form_id' => function () {
                return \App\Models\SquarespaceCustomForm::factory()->create()->id;
            },
            'variant_options' => $this->faker->numberBetween(1, 5),
        ];
    }
}
