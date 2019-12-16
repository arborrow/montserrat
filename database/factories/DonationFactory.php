<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Donation::class, function (Faker $faker) {
    return [
        'donor_id' => $faker->randomNumber(),
        'donation_description' => $faker->word,
        'donation_date' => $faker->dateTime(),
        'donation_amount' => $faker->randomFloat(),
        'donation_install' => $faker->randomFloat(),
        'terms' => $faker->text,
        'start_date' => $faker->dateTime(),
        'end_date' => $faker->dateTime(),
        'payment_description' => $faker->word,
        'retreat_id' => $faker->randomNumber(),
        'Notes' => $faker->text,
        'Notes1' => $faker->text,
        'Notice' => $faker->word,
        'Arrupe Donation Description' => $faker->word,
        'Target Amount' => $faker->randomNumber(),
        'Donation Type ID' => $faker->randomNumber(),
        'Thank You' => $faker->word,
        'AGC Donation Description' => $faker->word,
        'Pledge' => $faker->word,
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'remember_token' => Str::random(10),
        'event_id' => $faker->randomNumber(),
        'ppd_id' => $faker->randomNumber(),
    ];
});
