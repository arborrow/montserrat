<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TmpOfferingDedupFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $contact = \App\Models\Contact::factory()->create([
            'contact_type' => config('polanco.contact_type.individual'),
            'subcontact_type' => null,
        ]);
        $event = \App\Models\Retreat::factory()->create();

        return [
            'combo' => $contact->id.'-'.$event->id,
            'contact_id' => $contact->id,
            'event_id' => $event->id,
            'count' => $this->faker->numberBetween(1, 5),
            'merged' => $this->faker->boolean(),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
