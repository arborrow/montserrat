<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RelationshipTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name_a_b' => $this->faker->company(),
            'name_b_a' => $this->faker->jobTitle(),
            'label_a_b' => 'has a '.$this->faker->word().' of ',
            'label_b_a' => $this->faker->word().' for ',
            'description' => $this->faker->catchPhrase(),
            'contact_type_a' => array_rand(['Individual', 'Organization', 'Household']),
            'contact_type_b' => array_rand(['Individual', 'Organization', 'Household']),
            'contact_sub_type_a' => null,
            'contact_sub_type_b' => null,
            'is_reserved' => null,
            'is_active' => 1,
            'created_at' => $this->faker->dateTime('now'),
            'updated_at' => $this->faker->dateTime('now'),
        ];
    }
}
