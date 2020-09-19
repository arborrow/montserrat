<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Relationship::class, function (Faker $faker) {
    $relationship_type = \App\Models\RelationshipType::whereIsActive(1)->get()->random();
    $start_date = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '-60 days', $endDate = '+60 days')->getTimeStamp());

    return [
      'contact_id_a' => function () {
          return factory(App\Models\Contact::class)->create([
            ])->id;
      },
      'contact_id_b' => function () {
          return factory(App\Models\Contact::class)->create([
            ])->id;
      },
      'relationship_type_id' => $relationship_type->id,
      'start_date' => $start_date,
      'end_date' => null,
      'is_active' => '1',
      'description' => $faker->sentence,
      'remember_token' => Str::random(10),
    ];
});
