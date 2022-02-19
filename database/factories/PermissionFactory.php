<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $actions = ['show', 'create', 'update', 'delete', 'manage'];
        $action = $actions[array_rand($actions)];
        $model = $this->faker->word();

        return [
            'name' => $action.'-'.$model.$this->faker->randomNumber(6),
            'display_name' => ucfirst($action).' '.$model,
            'description' => $this->faker->words(5, true),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
