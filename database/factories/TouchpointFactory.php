<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Touchpoint::class, function (Faker $faker) {
    return [
        'type' => array_rand(array_flip(['Email', 'Call', 'Letter', 'Face', 'Other'])),
        'notes' => $faker->paragraph,
        'touched_at' => $faker->dateTime('now'),
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now'),

        'person_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'staff_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
    ];
});
