<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = $this->faker->lastName().' of '.$this->faker->city();

        return [
            'name' => $name,
            'label' => $name,
            'description' => $this->faker->sentence(),
            'notes' => $this->faker->text(100),
            'is_active' => 1,
            'parent_id' => null,
        ];
    }
}
