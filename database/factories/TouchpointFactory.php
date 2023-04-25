<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TouchpointFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => array_rand(array_flip(['Email', 'Call', 'Letter', 'Face', 'Other'])),
            'notes' => $this->faker->paragraph(),
            'touched_at' => $this->faker->dateTime('now'),
            'created_at' => $this->faker->dateTime('now'),
            'updated_at' => $this->faker->dateTime('now'),

            'person_id' => function () {
                return \App\Models\Contact::factory()->create()->id;
            },
            'staff_id' => function () {
                return \App\Models\Contact::factory()->create()->id;
            },
        ];
    }
}
