<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Registration::class, function (Faker $faker) {
// in theory, 'status_id' => array_rand(array_flip(config('polanco.registration_status_id'))),
// in theory, 'role_id' => array_rand(array_flip(config('participant_role_id'))),
// in practice, default to registered, retreatants and in tests hard code to innkeeper, assistant, director or ambassador
// consider defaults for room_id, donation_id
// default contact type is an individual; however, can be overridden to test cases for organizations
// don't create registrations for dead people
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create([
                'contact_type' => 1,
                'subcontact_type' => null,
                'is_deceased' => 0,
                'deceased_date' => null,
                ])->id;
        },
        'event_id' => function () {
            return factory(App\Retreat::class)->create()->id;
        },
        'status_id' => config('polanco.registration_status_id.registered'),
        'role_id' => config('polanco.participant_role_id.retreatant'),
        'register_date' => $faker->dateTime(),
        'source' => $faker->randomElement(config('polanco.registration_source')),
        'fee_level' => $faker->text,
        'is_test' => $faker->boolean,
        'is_pay_later' => $faker->boolean,
        'fee_amount' => $faker->randomFloat(),
        'registered_by_id' => null,
        'discount_id' => null,
        'fee_currency' => $faker->word,
        'campaign_id' => null,
        'discount_amount' => $faker->randomNumber(),
        'cart_id' => null,
        'must_wait' => $faker->randomNumber(),
        'remember_token' => Str::random(10),
        'registration_confirm_date' => $faker->dateTime(),
        'attendance_confirm_date' => $faker->dateTime(),
        'confirmed_by' => $faker->word,
        'notes' => $faker->text,
        'deposit' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
        'canceled_at' => null,
        'arrived_at' => $faker->dateTime(),
        'departed_at' => $faker->dateTime(),
        'room_id' => null,
        'donation_id' => null,
        'ppd_source' => $faker->word,
    ];
});
