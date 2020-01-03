<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Carbon\Carbon;

// Create a retreat with new contacts for innkeeper and assistant defining those relationships

$factory->define(App\Retreat::class, function (Faker $faker) {
  $start_date = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-60 days', $endDate = '+60 days')->getTimeStamp());
  $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addDays($faker->numberBetween(1, 5));
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
*/
    return [
        'title' => $faker->word,
        'summary' => $faker->text,
        'description' => $faker->text,
        'event_type_id' => $faker->numberBetween($min = 1, $max = 15),
        'start_date' => $start_date,
        'end_date' => $end_date,
        'is_active' => '1',
        'max_participants' => $faker->randomNumber(),
        'event_full_text' => $faker->text,
        'has_waitlist' => $faker->boolean,
        'idnumber' => $faker->unique()->randomNumber(8).$faker->unique()->lastName,
        'innkeeper_id' => function () {
            return factory(App\Contact::class)->create([
                'contact_type' => config('polanco.contact_type.individual'),
                'subcontact_type' => null,
                ])->id;
        },
        'assistant_id' => function () {
            return factory(App\Contact::class)->create([
                'contact_type' => config('polanco.contact_type.individual'),
                'subcontact_type' => null,    
            ])->id;
        },
        'remember_token' => Str::random(10),
    ];
});
