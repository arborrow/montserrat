<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'contact_id' => function () {
                return \App\Models\Contact::factory()->create()->id;
            },
            'asset_id' => function () {
                return \App\Models\Asset::factory()->create()->id;
            },
            'url' => $this->faker->url(),
            'website_type' => $this->faker->randomElement(config('polanco.website_types')),
            'description' => $this->faker->sentence(),
        ];
    }
}
