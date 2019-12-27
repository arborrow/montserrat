<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\GroupContact::class, function (Faker $faker) {
    return [
        'status' => 'Added',
        'group_id' => function () {
            return factory(App\Group::class)->create()->id;
        },
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
    ];
});
