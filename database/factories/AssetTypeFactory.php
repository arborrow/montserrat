<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AssetTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\AssetType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $label = $this->faker->word;

        return [
            'label' => $label,
            'name' => $label,
            'description' => $this->faker->sentence,
            'is_active' => 1,
            'parent_asset_type_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
