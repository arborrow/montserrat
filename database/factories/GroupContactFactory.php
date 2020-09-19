<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\GroupContact::class, function (Faker $faker) {
    return [
        'status' => 'Added',
        'group_id' => function () {
            return factory(App\Models\Group::class)->create()->id;
        },
        'contact_id' => function () {
            return factory(App\Models\Contact::class)->create()->id;
        },
    ];
});
