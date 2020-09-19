<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\ActivityContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'activity_id' => $this->faker->randomNumber(),
            'contact_id' => $this->faker->randomNumber(),
            'record_type_id' => $this->faker->randomNumber(),
            'remember_token' => Str::random(10),
        ];
    }
}
