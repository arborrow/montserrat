<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->lastname.' of '.$this->faker->city;

        return [
            'name' => $name,
            'label' => $name,
            'description' => $this->faker->sentence,
            'notes' => $this->faker->text(100),
            'is_active' => 1,
            'parent_id' =>  null,
        ];
    }
}
