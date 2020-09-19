<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Uom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $label = $this->faker->word;
        $type = $this->faker->randomElement(config('polanco.uom_types'));
        $description = $label.' of '.$type;

        return [
            'unit_name' => $label,
            'unit_symbol' => $label,
            'type' => $type,
            'description' => $description,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
