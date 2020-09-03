<?php

use Faker\Generator as Faker;

$factory->define(App\Snippet::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'label' => $faker->jobTitle,
        'locale' => $faker->locale,
        'snippet' => $faker->sentence,
    ];
});
