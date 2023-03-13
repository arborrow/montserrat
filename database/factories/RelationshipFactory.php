<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RelationshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $relationship_type = \App\Models\RelationshipType::whereIsActive(1)->get()->random();
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '-60 days', $endDate = '+60 days')->getTimeStamp());

        return [
            'contact_id_a' => function () {
                return \App\Models\Contact::factory()->create([
                ])->id;
            },
            'contact_id_b' => function () {
                return \App\Models\Contact::factory()->create([
                ])->id;
            },
            'relationship_type_id' => $relationship_type->id,
            'start_date' => $start_date,
            'end_date' => null,
            'is_active' => '1',
            'description' => $this->faker->sentence(),
            'remember_token' => Str::random(10),
        ];
    }
}
