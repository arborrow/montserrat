<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ContactType;
use Faker\Generator as Faker;

$factory->define(App\Organization::class, function (Faker $faker) {
    // organization subcontact types are in the range of
    $subcontact_type = $faker->numberBetween(9, 11);
    $organizaton_name = $faker->company;

    return [
        'contact_type' => config('polanco.contact_type.organization'),
        'subcontact_type' => $subcontact_type,
        'do_not_email' => $faker->boolean,
        'do_not_phone' => $faker->boolean,
        'do_not_mail' => $faker->boolean,
        'do_not_sms' => $faker->boolean,
        'do_not_trade' => $faker->boolean,
        'is_opt_out' => $faker->boolean,
        'sort_name' => $organizaton_name,
        'display_name' => $organizaton_name,
        'legal_name' => $organizaton_name,
        'image_URL' => $faker->word,
        'preferred_communication_method' => $faker->word,
        'preferred_language' => $faker->locale,
        'preferred_mail_format' => $faker->word,
        'hash' => $faker->word,
        'api_key' => $faker->word,
        'source' => $faker->word,
        'job_title' => $faker->word,
        'birth_date' => $faker->dateTime(),
        'is_deceased' => $faker->boolean,
        'deceased_date' => $faker->dateTime(),
        'household_name' => $organizaton_name,
        'organization_name' => $organizaton_name,
        'created_date' => $faker->dateTime(),
        'modified_date' => $faker->dateTime(),
        'remember_token' => Str::random(10),
    ];
});
