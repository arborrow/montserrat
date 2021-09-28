<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Email::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id' => function () {
                return \App\Models\Contact::factory()->create()->id;
            },
            'location_type_id' => function () {
                return \App\Models\LocationType::factory()->create()->id;
            },
            'email' => $this->faker->safeEmail,
            'is_primary' => $this->faker->boolean(),
            'is_billing' => $this->faker->boolean(),
            'on_hold' => $this->faker->boolean(),
            'is_bulkmail' => $this->faker->boolean(),
            'hold_date' => $this->faker->date(),
            'reset_date' => $this->faker->date(),
            'signature_text' => $this->faker->text(),
            'signature_html' => $this->faker->text(),
            'remember_token' => Str::random(10),
        ];
    }
}
