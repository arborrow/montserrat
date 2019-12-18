<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'contact_type' => $faker->randomNumber(),
        'subcontact_type' => $faker->randomNumber(),
        'do_not_email' => $faker->boolean,
        'do_not_phone' => $faker->boolean,
        'do_not_mail' => $faker->boolean,
        'do_not_sms' => $faker->boolean,
        'do_not_trade' => $faker->boolean,
        'is_opt_out' => $faker->boolean,
        'legal_identifier' => $faker->word,
        'external_identifier' => $faker->word,
        'sort_name' => $faker->word,
        'display_name' => $faker->word,
        'nick_name' => $faker->word,
        'legal_name' => $faker->word,
        'image_URL' => $faker->word,
        'preferred_communication_method' => $faker->word,
        'preferred_language' => $faker->word,
        'preferred_mail_format' => $faker->word,
        'hash' => $faker->word,
        'api_key' => $faker->word,
        'source' => $faker->word,
        'first_name' => $faker->firstName,
        'middle_name' => $faker->word,
        'last_name' => $faker->lastName,
        'email_greeting_custom' => $faker->word,
        'email_greeting_display' => $faker->word,
        'postal_greeting_custom' => $faker->word,
        'postal_greeting_display' => $faker->word,
        'addressee_greeting_custom' => $faker->word,
        'addressee_greeting_display' => $faker->word,
        'job_title' => $faker->word,
        'birth_date' => $faker->dateTime(),
        'is_deceased' => $faker->boolean,
        'deceased_date' => $faker->dateTime(),
        'household_name' => $faker->word,
        'organization_name' => $faker->word,
        'sic_code' => $faker->word,
        'is_deleted' => $faker->boolean,
        'created_date' => $faker->dateTime(),
        'modified_date' => $faker->dateTime(),
        'remember_token' => Str::random(10),
        'sort_name_count' => $faker->randomNumber(),
    ];
});
