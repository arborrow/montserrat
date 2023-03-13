<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SnippetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'label' => $this->faker->jobTitle(),
            'locale' => $this->faker->randomElement(\App\Models\Language::whereIsActive(1)->orderBy('label')->pluck('name', 'name')),
            'snippet' => $this->faker->sentence(),
        ];
    }
}
