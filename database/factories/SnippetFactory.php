<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Snippet::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'label' => $faker->jobTitle,
        'locale' => $faker->randomElement(\App\Models\Language::whereIsActive(1)->orderBy('label')->pluck('name', 'name')),
        'snippet' => $faker->sentence,
    ];
});
