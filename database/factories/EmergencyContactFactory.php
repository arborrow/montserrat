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
        'phone' => $faker->phoneNumber,
        'phone_alternate' => $faker->word,
        'remember_token' => Str::random(10),
    ];
});
