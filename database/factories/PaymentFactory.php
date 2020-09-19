<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Payment::class, function (Faker $faker) {
    $payment_methods = config('polanco.payment_method');

    return [
        'donation_id' => function () {
            return factory(App\Models\Donation::class)->create()->donation_id;
        },
        'payment_amount' => $faker->randomFloat(2, 0, 100000),
        'payment_date' => $faker->dateTime(),
        'payment_description' => $faker->randomElement($payment_methods),
        'cknumber' => $faker->word,
        'ccnumber' => $faker->word,
        'expire_date' => $faker->dateTime(),
        'authorization_number' => $faker->word,
        'note' => $faker->word,
        'ty_letter_sent' => $faker->word,
        'remember_token' => Str::random(10),
    ];
});
