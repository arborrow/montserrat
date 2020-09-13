<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomstateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Roomstate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'room_id' => function () {
            return Room::factory()->create()->id;
        },
    ];
    }
}
