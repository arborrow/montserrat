<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Note::class, function (Faker $faker) {
    return [
        'entity_table' => 'contact',
        'entity_id' => function () {
            return factory(App\Models\Contact::class)->create()->id;
        },
        'note' => $faker->sentence(),
        'subject' => $faker->randomElement(['Contact Note', 'Dietary Note', 'Diocese note', 'Health Note', 'Organization Note', 'Parish note', 'Pastor', 'Room Preference', 'Vendor note']),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
