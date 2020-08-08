<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

// TODO: to avoid confusion with agc letters in Spanish I'm limiting testing for now to $current_user
$factory->define(App\Donation::class, function (Faker $faker) {
    $description = \App\DonationType::whereIsActive(1)->get()->random();

    return [
        'donation_description' => $description->name,
        'donation_date' => $faker->dateTime(),
        'donation_amount' => $faker->randomFloat(2, 0, 100000),
        'donation_install' => $faker->randomFloat(2, 0, 5000),
        'terms' => $faker->text,
        'start_date' => $faker->dateTime(),
        'end_date' => $faker->dateTime(),
        'payment_description' => $faker->word,
        'Notes' => $faker->text,
        'Notes1' => $faker->text,
        'Notice' => $faker->word,
        'Arrupe Donation Description' => $faker->word,
        'Target Amount' => $faker->randomNumber(),
        'Donation Type ID' => $faker->randomNumber(),
        'Thank You' => $faker->randomElement($array = array ('Y','N')),
        'AGC Donation Description' => $faker->word,
        'Pledge' => $faker->word,
        'contact_id' => function () {
            return factory(App\Contact::class)->create([
              'preferred_language' => 'en_US',
              ])->id;
        },
        'event_id' => function () {
            return factory(App\Retreat::class)->create()->id;
        },
        'remember_token' => Str::random(10),
    ];
});
