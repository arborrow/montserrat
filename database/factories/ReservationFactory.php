<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(\App\Reservation::class)]
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'registration_id' => function () {
                return \App\Models\Registration::factory()->create()->id;
            },
            'room_id' => function () {
                return \App\Models\Room::factory()->create()->id;
            },
        ];
    }
}
