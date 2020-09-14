<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\GroupContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'status' => 'Added',
        'group_id' => function () {
            return Group::factory()->create()->id;
        },
        'contact_id' => function () {
            return Contact::factory()->create()->id;
        },
    ];
    }
}
