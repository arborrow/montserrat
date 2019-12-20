<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Retreat::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'summary' => $faker->text,
        'description' => $faker->text,
        'event_type_id' => $faker->numberBetween($min = 1, $max = 15),
        'start_date' => $faker->dateTime(),
        'end_date' => $faker->dateTime(),
        'is_active' => '1',
        'max_participants' => $faker->randomNumber(),
        'event_full_text' => $faker->text,
        'has_waitlist' => $faker->boolean,
        'idnumber' => $faker->unique()->randomNumber(),
        'innkeeper_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'assistant_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'remember_token' => Str::random(10),
    ];
});
