<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Attachment::class, function (Faker $faker) {
    return [
        'file_type_id' => null,
        'mime_type' => null,
        'uri' => null,
        'document' => null,
        'description' => $faker->sentence,
        'upload_date' => $faker->dateTime(),
        'remember_token' => Str::random(10),
        'entity' => null,
        'entity_id' => $faker->randomDigit,
    ];
});
