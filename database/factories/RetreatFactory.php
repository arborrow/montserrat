<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Create a retreat with new contacts for innkeeper and assistant defining those relationships

class RetreatFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $start_date = Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '-60 days', $endDate = '+60 days')->getTimeStamp());
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays($this->faker->numberBetween(1, 5));

        // TODO: evaluate whether this is desireable or necessary (leaving out for now)
        // added checks in show blade to ensure that the relationship is present ($retreat->assistant and $retreat->innkeeper)
        // If an assistant_id or innkeeper_id is manually set the relationship
        // for that contact_id may not exist in the relationship table
        // as an assistant/innkeeper for the retreat house (self)
        /*
          $innkeeper = factory(\App\Contact::class)->create();
          $innkeeper_relationship = factory(\App\Relationship::class)->create(
              [
                 'contact_id_a' => config('polanco.self.id'),
                 'contact_id_b' => $innkeeper->id,
                 'relationship_type_id' => config('polanco.relationship_type.retreat_innkeeper'),
              ]);
          $assistant = factory(\App\Contact::class)->create();
          $assistant_relationship = factory(\App\Relationship::class)->create(
              [
                 'contact_id_a' => config('polanco.self.id'),
                 'contact_id_b' => $assistant->id,
                 'relationship_type_id' => config('polanco.relationship_type.retreat_innkeeper'),
              ]);
          // innkeeper and assistant methods in retreat model assume individual contact type and so we force it here in the factory as well
        */
        return [
            'title' => $this->faker->word(),
            'summary' => $this->faker->text(),
            'description' => $this->faker->text(),
            'event_type_id' => $this->faker->numberBetween($min = 1, $max = 15),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'is_active' => '1',
            'max_participants' => $this->faker->randomNumber(),
            'event_full_text' => $this->faker->text(),
            'has_waitlist' => $this->faker->boolean(),
            'idnumber' => $this->faker->unique()->randomNumber(8).$this->faker->unique()->lastName(),
            'remember_token' => Str::random(10),
        ];
    }
}
