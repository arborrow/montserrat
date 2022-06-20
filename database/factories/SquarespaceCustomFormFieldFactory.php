<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SquarespaceCustomFormFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = ucwords(implode(" ",$this->faker->words(3)));
        $variable = strtolower(str_replace(" ","_",$name));
        return [
            'name' => $name,
            'form_id' => function () {
                return \App\Models\SquarespaceCustomForm::factory()->create()->id;
            },
            'name' => $name,
            'sort_order' => $this->faker->numberBetween(1,20), 
            'type' => $this->faker->randomElement(['select', 'name', 'address', 'phone', 'email', 'date', 'person', 'text', 'textarea']),
            'variable_name' => $variable,
        ];
    }
}
