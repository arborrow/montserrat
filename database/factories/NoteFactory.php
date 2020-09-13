<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'entity_table' => 'contact',
        'entity_id' => function () {
            return Contact::factory()->create()->id;
        },
        'note' => $this->faker->sentence(),
        'subject' => $this->faker->randomElement(['Contact Note', 'Dietary Note', 'Diocese note', 'Health Note', 'Organization Note', 'Parish note', 'Pastor', 'Room Preference', 'Vendor note']),
        'created_at' => now(),
        'updated_at' => now(),
    ];
    }
}
