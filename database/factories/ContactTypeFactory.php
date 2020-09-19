<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ContactType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'label' => $faker->word,
        'description' => $faker->text,
        'image_URL' => $faker->word,
        'parent_id' => $faker->randomNumber(),
        'is_active' => $faker->boolean,
        'is_reserved' => $faker->boolean,
        'status' => $faker->word,
        'remember_token' => Str::random(10),
    ];
});
