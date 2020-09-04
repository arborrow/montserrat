<?php

use Faker\Generator as Faker;

$factory->define(App\Snippet::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'label' => $faker->jobTitle,
        'locale' => $faker->randomElement(\App\Language::whereIsActive(1)->orderBy('label')->pluck('name','name')),
        'snippet' => $faker->sentence,
    ];
});
