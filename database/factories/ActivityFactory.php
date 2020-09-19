<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'source_record_id' => $this->faker->randomNumber(),
            'activity_type_id' => $this->faker->randomNumber(),
            'subject' => $this->faker->word,
            'activity_date_time' => $this->faker->dateTime(),
            'duration' => $this->faker->randomNumber(),
            'location' => $this->faker->word,
            'phone_id' => $this->faker->randomNumber(),
            'phone_number' => $this->faker->phoneNumber,
            'details' => $this->faker->text,
            'status_id' => $this->faker->randomNumber(),
            'priority_id' => $this->faker->randomNumber(),
            'parent_id' => $this->faker->randomNumber(),
            'is_test' => $this->faker->boolean,
            'medium_id' => $this->faker->randomNumber(),
            'is_auto' => $this->faker->boolean,
            'relationship_id' => $this->faker->randomNumber(),
            'is_current_revision' => $this->faker->boolean,
            'original_id' => $this->faker->randomNumber(),
            'result' => $this->faker->word,
            'is_deleted' => $this->faker->boolean,
            'campaign_id' => $this->faker->randomNumber(),
            'engagement_level' => $this->faker->randomNumber(),
            'weight' => $this->faker->randomNumber(),
            'is_star' => $this->faker->boolean,
            'remember_token' => Str::random(10),
        ];
    }
}
