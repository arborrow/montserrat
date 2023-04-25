<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupContactFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'status' => 'Added',
            'group_id' => function () {
                return \App\Models\Group::factory()->create()->id;
            },
            'contact_id' => function () {
                return \App\Models\Contact::factory()->create()->id;
            },
        ];
    }
}
