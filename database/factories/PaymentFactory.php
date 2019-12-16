<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Payment::class, function (Faker $faker) {
    return [
        'donation_id' => function () {
            return factory(App\Donation::class)->create()->donation_id;
        },
        'payment_amount' => $faker->randomFloat(),
        'payment_date' => $faker->dateTime(),
        'payment_description' => $faker->word,
        'cknumber' => $faker->word,
        'ccnumber' => $faker->word,
        'expire_date' => $faker->dateTime(),
        'authorization_number' => $faker->word,
        'note' => $faker->word,
        'ty_letter_sent' => $faker->word,
        'remember_token' => Str::random(10),
    ];
});
