<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\EmergencyContact::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'name' => $faker->name,
        'relationship' => $faker->word,
        'phone' => '9403216010,'.$faker->numberBetween(111,999),
        'phone_alternate' => '9403216030,'.$faker->numberBetween(111,999),
        'remember_token' => Str::random(10),
    ];
});
