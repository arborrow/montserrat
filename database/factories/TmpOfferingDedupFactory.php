<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\TmpOfferingDedup::class, function (Faker $faker) {
    $contact = factory(App\Contact::class)->create([
      'contact_type' => config('polanco.contact_type.individual'),
      'subcontact_type' => NULL,
    ]);
    $event = factory(App\Retreat::class)->create();
    return [
      'combo' => $contact->id . '-' . $event->id,
      'contact_id' => $contact->id,
      'event_id' => $event->id,
      'count' => $faker->numberBetween(1,5),
      'merged' => $faker->boolean,
      'created_at' => $faker->dateTime(),
    ];
});
