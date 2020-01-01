<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\EventType::class, function (Faker $faker) {
    return [
      'label' => $faker->word,
      'value' => $faker->word,
      'name' => $faker->word,
      'description' => $faker->sentence,
      'created_at' => $faker->dateTime('now'),
      'updated_at' => $faker->dateTime('now'),
      'remember_token' => Str::random(10),
    ];
});
