<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Registration::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'event_id' => function () {
            return factory(App\Retreat::class)->create()->id;
        },
        'register_date' => $faker->dateTime(),
        'source' => $faker->word,
        'fee_level' => $faker->text,
        'is_test' => $faker->boolean,
        'is_pay_later' => $faker->boolean,
        'fee_amount' => $faker->randomFloat(),
        'fee_currency' => $faker->word,
        'discount_amount' => $faker->randomNumber(),
        'must_wait' => $faker->randomNumber(),
        'remember_token' => Str::random(10),
        'registration_confirm_date' => $faker->dateTime(),
        'attendance_confirm_date' => $faker->dateTime(),
        'confirmed_by' => $faker->word,
        'notes' => $faker->text,
        'deposit' => $faker->randomFloat(),
        'canceled_at' => $faker->dateTime(),
        'arrived_at' => $faker->dateTime(),
        'departed_at' => $faker->dateTime(),
        'ppd_source' => $faker->word,
    ];
});
