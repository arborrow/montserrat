<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Website::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'contact_id' => function () {
            return Contact::factory()->create()->id;
        },
        'asset_id' => function () {
            return Asset::factory()->create()->id;
        },
        'url' => $this->faker->url,
        'website_type' => $this->faker->randomElement(config('polanco.website_types')),
        'description' => $this->faker->sentence,
    ];
    }
}
