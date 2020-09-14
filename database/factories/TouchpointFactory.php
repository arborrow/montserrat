<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class TouchpointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Touchpoint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'type' => array_rand(array_flip(['Email', 'Call', 'Letter', 'Face', 'Other'])),
        'notes' => $this->faker->paragraph,
        'touched_at' => $this->faker->dateTime('now'),
        'created_at' => $this->faker->dateTime('now'),
        'updated_at' => $this->faker->dateTime('now'),

        'person_id' => function () {
            return Contact::factory()->create()->id;
        },
        'staff_id' => function () {
            return Contact::factory()->create()->id;
        },
    ];
    }
}
