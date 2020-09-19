<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $group_name = ucfirst(implode(' ', $this->faker->words));

        return [
            'name' => $group_name,
            'title' => Str::plural($group_name),
            'description' => 'Group of '.Str::plural($group_name),
            'is_active' => 1,
            'visibility' => 'User and User Admin Only',
            'is_hidden' => 0,
            'is_reserved' => 0,
            'created_id' => null,
            'deleted_at' => null,
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-12 days', $endDate = '-6 days'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = '-1 days'),
        ];
    }
}
